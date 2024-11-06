<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Auth\LoginRequest;
use App\Http\Requests\Admin\UpdateUserRequest;
use App\Http\Requests\Admin\User\UpdateRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Permission;

class AuthController extends Controller
{
    public function login(LoginRequest $request)
    {
        $type = filter_var($request->email, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        if (Auth::attempt([$type => $request->email, 'password' => $request->password])) {
            $user = Auth::user();
            $user['token'] = $user->createToken('user_token')->plainTextToken;
            return apiResponse(true, 200, $user);
        }
        return apiResponse(false, 401, __('auth.failed'));
    }

    public function profile()
    {
        $user = Auth::user();
        $permissions = Permission::query()->whereHas('roles', function ($q) use ($user) {
            $q->whereIn('id', $user->roles()->pluck('id'));
        })->select('id', 'name')->get();
        return apiResponse(true, 200, [
            'user' => $user,
            'permissions' => $permissions,
        ]);
    }

    public function updateProfile(UpdateUserRequest $request)
    {
        $user = Auth::user();
        if (!$user) {
            return apiResponse(false, 404, __('words.Not found'));
        }
        $user->name = $request->name;
        $user->phone = $request->phone;
        $user->email = $request->email;
        $user->username = $request->username;
        if ($request->hasFile('image')) {
            deleteFile($user->image);
            $user->image = uploadFile('users', $request->file('image'));
        }
        if ($request->password)
            $user->password = bcrypt($request->password);

        $user->save();
    }

    public function logout()
    {
        $user = Auth::user();
        $user->tokens()->delete();
        return apiResponse(true, 200);
    }
}

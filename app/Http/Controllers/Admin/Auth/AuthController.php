<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Auth\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        return apiResponse(true, 200, $user);
    }

    public function logout()
    {
        $user = Auth::user();
        $user->tokens()->delete();
        return apiResponse(true, 200);
    }
}

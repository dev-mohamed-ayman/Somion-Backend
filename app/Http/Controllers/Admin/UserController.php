<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\User\CreateRequest;
use App\Http\Requests\Admin\User\UpdateRequest;
use App\Http\Resources\Api\Admin\UserResource;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $users = User::query()->latest()->paginate(limit(request()->limit));

        return apiResponse(true, 200, [
            'users' => UserResource::collection($users),
            'pagination' => pagination($users)
        ]);
    }

    public function show(User $user)
    {
        return apiResponse(true, 200, new UserResource($user));
    }

    public function create(CreateRequest $request)
    {
        $user = new User();
        $user->name = $request->name;
        $user->phone = $request->phone;
        $user->email = $request->email;
        $user->username = $request->username;
        $user->status = $request->status;
        $user->type = 'admin';
        if ($request->hasFile('image'))
            $user->image = uploadFile('users', $request->file('image'));
        $user->password = bcrypt($request->password);
        $user->save();

        $user->syncRoles($request->roles);

        return apiResponse(true, 201, __('words.Successfully created'));
    }

    public function update(UpdateRequest $request)
    {
        $user = User::findOr($request->id, function () {
            return apiResponse(false, 404, __('words.User not found'));
        });
        $user->name = $request->name;
        $user->phone = $request->phone;
        $user->email = $request->email;
        $user->username = $request->username;
        $user->status = $request->status;
        $user->type = 'admin';
        if ($request->hasFile('image')) {
            deleteFile($user->image);
            $user->image = uploadFile('users', $request->file('image'));
        }
        if ($request->password)
            $user->password = bcrypt($request->password);

        $user->save();

        $user->syncRoles($request->roles);

        return apiResponse(true, 201, __('words.Successfully updated'));
    }

    public function destroy(User $user)
    {
        deleteFile($user->image);
        $user->delete();
        return apiResponse(true, 200, __('words.Successfully deleted'));
    }
}

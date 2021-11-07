<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserLoginRequest;
use App\Http\Requests\UserRegisterRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Http\Resources\UserResource;
use App\Models\File;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function register(UserRegisterRequest $request)
    {
        $user = User::create($request->validated());
        $token = $user->createToken('usertoken')->plainTextToken;

        return UserResource::make($user)->additional(['token' => $token]);
    }

    public function logout()
    {
        Auth::user()->tokens()->delete();

        return response(['message' => 'succes']);
    }

    public function login(UserLoginRequest $request)
    {
        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password))
            return response(['message' => 'invalid-credentials'], 401);
        else
            $token = $user->createToken('usertoken')->plainTextToken;

        return UserResource::make($user)->additional(['token' => $token]);
    }

    public function show(User $user)
    {
        return UserResource::make($user);
    }

    public function update(UserUpdateRequest $request, User $user)
    {
        $user->update($request->validated());
        if ($request->has('avatar'))
        {
            if ($user->avatar()->exists()) $user->avatar()->update(File::store($request->avatar, 'public', 'avatars'));
            else $user->avatar()->associate(File::create(File::store($request->avatar, 'public', 'avatars')))->save();
        }
    }
}

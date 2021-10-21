<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserLoginRequest;
use App\Http\Requests\UserRegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function register(UserRegisterRequest $request)
    {
        $user = User::create($request->validated());
        $token = $user->createToken('usertoken')->plainTextToken;

        return response(['token' => $token]);
    }

    public function logout()
    {
        auth()->user()->tokens()->delete();

        return response(['message' => 'succes']);
    }

    public function login(UserLoginRequest $request)
    {
        $user = User::where('name', $request->safe(['name']))->first();

        if (!$user || !Hash::check($request->validated()['password'], $user->password))
            return response(['message' => 'invalid-credentials'], 401);
        else
            $token = $user->createToken('usertoken')->plainTextToken;

        return response(['token' => $token]);
    }
}

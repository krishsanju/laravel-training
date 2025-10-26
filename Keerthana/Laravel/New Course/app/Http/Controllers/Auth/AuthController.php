<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Requests\LoginRequest;
use App\Http\Responses\ApiResponse;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\RegisterRequest;

class AuthController extends Controller
{
    public function register(RegisterRequest $request)
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $token = $user->createToken('API Token')->accessToken;

        return ApiResponse::setMessage('User registered successfully')
                          ->mergeResults(['token' => $token, 'user' => $user])
                          ->response(Response::HTTP_OK);
    }

    public function login(LoginRequest $request)
    {
        if (!Auth::attempt($request->only('email', 'password'))) {
            return ApiResponse::setMessage('Invalid credentials')
                              ->response(Response::HTTP_UNAUTHORIZED);
        }

        $user = User::whereId(1)->first();
        $token = $user->createToken('API Token')->accessToken;

        return ApiResponse::setMessage('Login successful')
                          ->mergeResults(['token' => $token, 'user' => $user])
                          ->response(Response::HTTP_OK);
    }
}

<?php

namespace App\Http\Controllers\Api;

use App\Response\ApiResponse;
use Illuminate\Http\Request;
use App\Services\AuthService;
use Illuminate\Http\Response;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;

class AuthController extends Controller
{
    public function __construct(private AuthService $authService) {}

    public function register (RegisterRequest $request)
    {
        $data = $this->authService->register($request->validated());

        return ApiResponse::setMessage('Registration successful')
            ->setData($data)
            ->response(Response::HTTP_CREATED);
    }

    public function login(LoginRequest $request)
    {
        $data = $this->authService->login($request->validated());

        return ApiResponse::setMessage('Login successful')
            ->setData($data)
            ->response(Response::HTTP_OK);
    }

    // public function refreshToken(Request $request)
    // {
    //     $data = $this->authService->refreshToken($request->refresh_token);

    //     return ApiResponse::setMessage('Token refreshed')
    //         ->setData($data)
    //         ->response(Response::HTTP_OK);
    // }

    // public function forgotPassword(Request $request)
    // {
    //     $this->authService->forgotPassword($request->email);

    //     return ApiResponse::setMessage('Password reset link sent')
    //         ->response(Response::HTTP_OK);
    // }

    // public function resetPassword(Request $request)
    // {
    //     $this->authService->resetPassword($request->all());

    //     return ApiResponse::setMessage('Password has been reset')
    //         ->response(Response::HTTP_OK);
    // }

    // public function verifyEmail($id, $hash)
    // {
    //     $this->authService->verifyEmail($id, $hash);

    //     return ApiResponse::setMessage('Email verified successfully')
    //         ->response(Response::HTTP_OK);
    // }

    // public function resendVerification(Request $request)
    // {
    //     $this->authService->resendVerification($request->email);

    //     return ApiResponse::setMessage('Verification email sent')
    //         ->response(Response::HTTP_OK);
    // }

    public function logout(Request $request)
    {
        $this->authService->logout($request->user());

        return ApiResponse::setMessage('Logged out successfully')
            ->response(Response::HTTP_OK);
    }

    // public function deleteAccount(Request $request)
    // {
    //     $this->authService->deleteAccount($request->user());

    //     return ApiResponse::setMessage('Account deleted successfully')
    //         ->response(Response::HTTP_OK);
    // }
}

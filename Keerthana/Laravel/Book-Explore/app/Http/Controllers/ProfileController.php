<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Response\ApiResponse;
use App\Services\UserService;
use Illuminate\Http\Response;
use App\Models\User;
use App\Http\Requests\UpdateProfileRequest;

class ProfileController extends Controller
{
    protected UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function show(Request $request)
    {
        $user = $request->user();

        if (!$user) {
            return ApiResponse::setMessage('Unauthenticated')
                ->response(Response::HTTP_UNAUTHORIZED);
        }
        $user = $this->userService->getProfile($user->id);
        info($user);
        return ApiResponse::setMessage('Profile fetched successfully')
                ->setData($user)
                ->response(Response::HTTP_OK);
    }

    public function update(UpdateProfileRequest $request)
    {
        $user = $request->user();
        if (!$user) {
            return ApiResponse::setMessage('Unauthenticated')
                ->response(Response::HTTP_UNAUTHORIZED);
        }

        $updatedUser = $this->userService->updateProfile($user->id, $request->validated());
        return ApiResponse::setData($updatedUser)
                ->setMessage('Profile updated successfully')
                ->response(Response::HTTP_OK);
    }

    public function destroy(Request $request)
    {
        $user = $request->user();

        if (!$user) {
            return ApiResponse::setMessage('Unauthenticated')
                ->response(Response::HTTP_UNAUTHORIZED);
        }
        $this->userService->deleteAccount($user->id);
        return ApiResponse::setMessage('Account deleted successfully')
                ->response(Response::HTTP_OK);
    }

    public function activity(Request $request)
    {
        $user = $request->user();

        if (!$user) {
            return ApiResponse::setMessage('Unauthenticated')
                ->response(Response::HTTP_UNAUTHORIZED);
        }
        $logs = $this->userService->getActivityLogs($user->id);
        return ApiResponse::setData($logs)
                ->setMessage('Activity logs fetched')
                ->response(Response::HTTP_OK);
    }
}

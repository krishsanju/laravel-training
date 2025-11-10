<?php

namespace App\Services;

use App\Models\User;
use App\Mail\UserBlockedMail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Contracts\UserRepositoryInterface;

class UserService
{
    protected UserRepositoryInterface $userRepo;
    protected ActionLogService $logService;

    public function __construct(UserRepositoryInterface $userRepo, ActionLogService $logService)
    {
        $this->userRepo = $userRepo;
        $this->logService = $logService;
    }

    public function getProfile(int $userId)
    {
        return User::findOrFail($userId);
    }

    public function updateProfile(int $userId, array $data)
    {
        $user = User::findOrFail($userId);

        $this->userRepo->update($user, $data);

        $this->logService->log($user->id, 'profile_updated', 'User updated their profile');

        return $user->fresh();
    }

    public function deleteAccount(int $userId)
    {
        $user = User::findOrFail($userId);

        $this->userRepo->softDelete($user);

        $this->logService->log($userId, 'account_deleted', 'User deleted profile');

        return true;
    }

    public function getActivityLogs(int $userId)
    {
        return $this->logService->getLogsForUser($userId);
    }

    public function getAllActivityLogs()
    {
        return $this->logService->getAllLogs();
    }

    public function blockUser(int $userId)
    {
        $user = User::find($userId);

        if (!$user) {
            throw new \Exception('User not found');
        }

        if ($user->is_blocked) {
            return $user; // already blocked
        }

        $user->update([
            'is_blocked' => true,
        ]);

        Mail::to($user->email)->send(new UserBlockedMail($user));

        $this->logService->log($userId, 'account_blocked', 'User is blocked');

        return $user;
    }
}

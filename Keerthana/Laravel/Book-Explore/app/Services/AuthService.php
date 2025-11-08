<?php

namespace App\Services;

use App\Contracts\UserRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Validator;

class AuthService
{
    protected UserRepositoryInterface $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * Register a new user and return access token
     */
    public function register(array $data): array
    {
        $user = $this->userRepository->create([
            'name'     => $data['name'],
            'email'    => $data['email'],
            'password' => bcrypt($data['password']),
        ]);

        return $this->generateTokenResponse($user);
    }

    /**
     * Login and issue a personal access token
     */
    public function login(array $data): array
    {
        $user = $this->userRepository->findByEmail($data['email']);

        if (! $user || ! Hash::check($data['password'], $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['Invalid credentials.'],
            ]);
        }

        if ($user->is_blocked ?? false) {
            throw ValidationException::withMessages([
                'email' => ['Your account is blocked.'],
            ]);
        }

        return $this->generateTokenResponse($user);
    }

    /**
     * Logout (revoke all tokens)
     */
    public function logout($user): void
    {
        if (! $user) {
            throw ValidationException::withMessages([
                'user' => ['Unauthenticated.'],
            ]);
        }

        // revoke all tokens
        $user->tokens()->delete();
    }

    /**
     * Generate an access token response array
     */
    protected function generateTokenResponse($user): array
    {
        // create a new personal access token
        $tokenResult = $user->createToken('auth_token');
        $token = $tokenResult->accessToken;

        return [
            'token_type' => 'Bearer',
            'access_token' => $token,
            'user' => $user,
        ];
    }
}

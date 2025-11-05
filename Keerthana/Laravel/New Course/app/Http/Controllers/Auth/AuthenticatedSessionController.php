<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Models\UserActivity;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\Auth\LoginRequest;

class AuthenticatedSessionController extends Controller
{    protected $user;
    protected $userActivity;

    public function __construct(User $user, UserActivity $userActivity)
    {
        $this->user = $user;
        // $this->userActivity = $userActivity;
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request)
    {   $user = $this->user->where('email', $request->email)->first();

        if (! $user || ! Hash::check($request->password, $user->password)) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }

        
        $user->tokens()->delete();
        $token = $user->createToken('api_token')->plainTextToken;
        
        $user->userActivities()->getRelated()->incrementLogin($user);
        return response()->json([
            'user' => $user,
            'token' => $token,
        ]);
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request)
    {   $request->user()->currentAccessToken()->delete();
    
        return response()->json([
            // 'user'=> $request->user(),
            'message' => "user logged out",
        ]);
    }
}

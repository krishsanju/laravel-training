<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Responses\ApiResponse;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use PhpOption\None;

class AuthController extends Controller
{
        
    public function registerFormSubmit(RegisterRequest $request){

        $user = User::createUser($request->all());
        return ApiResponse::setMessage($user, $message = "User registered in successfully!")->send();;
    }

    public function loginFormSubmit(LoginRequest $request){
    
        $user = User::verifyCredentials($request->email, $request->password);

        if ($user) {
            return ApiResponse::setMessage($user, $message = "User logged in successfully!")->send();;
        }

        return back()->withErrors([
            'email' => 'Invalid credentials provided.',
        ]);
    }

    // public function logout(Request $request)
    // {
    //     $request->session()->invalidate();
    //     $request->session()->regenerateToken();

    //     return redirect()->route('login.form')->with('success', 'Logged out successfully.');
    // }
    
}

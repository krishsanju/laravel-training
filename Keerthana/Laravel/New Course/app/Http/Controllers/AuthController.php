<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use PhpOption\None;

class AuthController extends Controller
{
    
    
    public function registerForm(){ return view('auth.register');}
    
    public function registerFormSubmit(RegisterRequest $request){

        $user = User::createFormRequest($request->all());

        // Auth::login($user);

        return response()->json([
            'status' => 'Success',
            'message' => 'User registered and logged in successfully!',
            'user' => $user
        ]);
    }

    public function loginForm(){
        return view("auth.login");
    }
    
    public function loginFormSubmit(LoginRequest $request){
    
        $user = User::verifyCredentials($request->email, $request->password);

        if ($user) {
            // Auth::login($user); 
            return response()->json(['status' => 'login done']);
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

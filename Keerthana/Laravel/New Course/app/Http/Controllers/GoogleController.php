<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class GoogleController extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        // try{
            $user = Socialite::driver('google')->stateless()->user();
            info(json_encode($user));

            $findUser = User::where('google_id', $user->getId())->first();

            if($findUser){
                Auth::login($findUser);
            }else{
                $newUser = User::create([
                    'name' => $user->getName(),
                    'email' => $user->getEmail(),
                    'google_id' => $user->getId(),
                    'password' => bcrypt('password'),  //use ledhu anaru but petali antunaru
                ]);

                Auth::login($newUser);
            }
            return redirect()->route('loggedIn');
            
        // }catch(\Exception $e){
        //     return redirect('/login')->with('error', "Google login failed");
        // }
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }
}

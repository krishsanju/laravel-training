<?php

namespace App\Http\Controllers\Api;

use App\Http\Response\ApiResponse;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;
use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;

class UserController extends Controller
{
    public function register(RegisterRequest $request)
    {
        // dd($request->all());
        $data = $request->all();

        return User::createUser($data);
    }

    public function login(LoginRequest $request)
    {
        $data = $request->all();

        return User::login($data);
    }

    public function userDetails(Request $request)
    {
        // $user = User::find($id);
        $user = $request->user();
        return (new ApiResponse)
                ->setMessage("User Found")
                ->setData($user->toArray())
                ->returnResponse(200);
    }

    public function logout(Request $request)
    {
        $email = $request->input("email");
        User::logOut($email);
    }


}

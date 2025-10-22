<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Response\ApiResponse;
use App\Http\Requests\LoginRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use App\Http\Requests\RegisterRequest;

class UserController extends Controller
{
    public function register(RegisterRequest $request)
    {
        // dd($request->all());
        $data = $request->all();
        $data['email_verified_at'] = now();
        info('okay gotttttttt the dataaaaaaaaaaaa');

        $user = User::createUser($data);
        info('okay gotttttttt the userrrrrrrrrrrrrrrrrrr');

        $response = Http::post(config('app.url') . '/oauth/token', [
            'grant_type' => 'password',
            'client_id' => config('passport.password.cliendId'),
            'client_secret' => config('passport.password.secret'),
            'username' => $data['email'],
            'password' => $data['password'],
            'scope' => '',
        ]);
        $user['token'] = $response->json();

        // $tokenResult = $user->createToken('Personal Access Token');
    
        // // Optional: format response
        // $token = [
        //     'access_token' => $tokenResult->accessToken,
        //     'token_type' => 'Bearer',
        //     'expires_at' => $tokenResult->token->expires_at,
        // ];

        return response()->json([
            'success' => true,
            'statusCode' => 201,
            'message' => 'User has been registered successfully.',
            'data' => [$user],
        ], 201);
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

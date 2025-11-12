<?php

namespace App\Http\Controllers\Api;


use App\Models\User;
use Illuminate\Http\Request;

use App\Response\ApiResponse;

use App\Services\AuthService;

use Illuminate\Support\Facades\DB;

use App\Http\Controllers\Controller;
use Nyholm\Psr7\Factory\Psr17Factory;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\Auth\RegisterRequest;
use Nyholm\Psr7Server\ServerRequestCreator;
use Psr\Http\Message\ServerRequestInterface;
// use Nyholm\Psr7\Response;
use Symfony\Component\HttpFoundation\Response;
use Nyholm\Psr7Server\ServerRequestCreatorInterface;
use Laravel\Passport\Http\Controllers\AccessTokenController;


class AuthController extends Controller
{
    protected $psr17Factory;
    protected AuthService $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
        $this->psr17Factory = new Psr17Factory();
    }


    //REGISTER
    public function register(RegisterRequest $request)
    {
        $data = $this->authService->register($request->all());
        $token = json_decode($data[1]->getContent(), true);
        $response =  [
            'user' => $data[0],
            'token' => $token
        ];

        return ApiResponse::setMessage('Registration successful.')
            ->setData($response)
            ->response(201);
    }

    //LOGIN
    public function login(LoginRequest $request)
    {
        $data = $this->authService->login($request->validated());
        $token = json_decode($data[1]->getContent(), true);
        $response =  [
            'user' => $data[0],
            'token' => $token
        ];

        return ApiResponse::setMessage('Login successful.')
            ->setData($response)
            ->response(Response::HTTP_OK);
    }

    //REFRESH TOKEN
    // public function refreshToken(Request $request)
    // {
    //     $validator = Validator::make($request->all(), [
    //         'refresh_token' => 'required|string',
    //     ]);
    //     if ($validator->fails()) {
    //         return response()->json(['errors' => $validator->errors()], 422);
    //     }

    //     // $data = $this->authService->refreshToken($request->refresh_token);

    //     // return ApiResponse::setData($data)
    //     //     ->setMessage('Token refreshed successfully')
    //     //     ->response(Response::HTTP_OK);


    //     $clientId = env('PASSPORT_PASSWORD_CLIENT_ID');
    //     $clientSecret = env('PASSPORT_PASSWORD_CLIENT_SECRET');


    //     $params = [
    //         'grant_type' => 'refresh_token',
    //         'refresh_token' => $request->refresh_token,
    //         'client_id' => $clientId,
    //         'client_secret' => $clientSecret,
    //         'scope' => '',
    //     ];


    //     $psrFactory = $this->psr17Factory;
    //     $uri = $psrFactory->createUri('/oauth/token');
    //     $serverRequest = $psrFactory->createServerRequest('POST', $uri, []);
    //     $serverRequest = $serverRequest->withParsedBody($params);


    //     $accessTokenController = app(AccessTokenController::class);
    //     $psrResponse = $accessTokenController->issueToken($serverRequest, new Response());

    //     return $psrResponse;
    // }


    //LOGOUT
    public function logout(Request $request)
    {
        // $validator = Validator::make($request->all(), [
        //     'refresh_token' => 'required|string',
        // ]);
        // if ($validator->fails()) {
        //     return response()->json(['errors' => $validator->errors()], 422);
        // }


        // $this->authService->logout($request->user());

        // return ApiResponse::setMessage('Logged out successfully')
        //     ->response(Response::HTTP_OK);


        $user = $request->user();

        if (!$user) {
            return response()->json(['error' => 'Unauthenticated'], 401);
        }


        // If using the token guard, the token is available via $request->user()->token()
        // but with Passport and `auth:api`, you can get token id from the bearer token


        $accessToken = $request->user()->token();


        if ($accessToken) {
            // Revoke access token
            $accessToken->revoke();


            // Revoke associated refresh tokens
            DB::table('oauth_refresh_tokens')
                ->where('access_token_id', $accessToken->id)
                ->update(['revoked' => true]);
        }


        return response()->json(['message' => 'Logged out successfully']);
    }

    public function forgotPassword(Request $request)
    {
        $request->validate(['email' => 'required|email']);
        $this->authService->forgotPassword($request->email);

        return ApiResponse::setMessage('Password reset link sent')
            ->response(Response::HTTP_OK);
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'code' => 'required|numeric',
            'password' => 'required|min:8|confirmed',
        ]);


        return ApiResponse::setMessage('Password reset successful')->response(200);
    }
}

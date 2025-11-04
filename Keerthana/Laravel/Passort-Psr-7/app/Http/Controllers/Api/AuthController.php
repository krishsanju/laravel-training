<?php


namespace App\Http\Controllers\Api;


use App\Models\User;
use Nyholm\Psr7\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Nyholm\Psr7\Factory\Psr17Factory;
use Illuminate\Support\Facades\Validator;
use Nyholm\Psr7Server\ServerRequestCreator;
use Psr\Http\Message\ServerRequestInterface;
use Nyholm\Psr7Server\ServerRequestCreatorInterface;
use Laravel\Passport\Http\Controllers\AccessTokenController;


class AuthController extends Controller
{
    protected $psr17Factory;


    public function __construct()
    {
        $this->psr17Factory = new Psr17Factory();
    }

    /**
     * Register user and issue access + refresh token
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
        ]);


        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }


        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return $this->issueToken($request->email, $request->password);
    }

    /**
     * Login - validate and issue tokens
     */
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string',
        ]);


        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }


        // use typical auth attempt
        if (!Auth::guard('web')->attempt($request->only('email', 'password'))) {
            return response()->json(['error' => 'Invalid credentials'], 401);
        }


        return $this->issueToken($request->email, $request->password);
    }

    /**
     * Create a PSR-7 ServerRequest and call Passport's AccessTokenController->issueToken()
     * to get access & refresh token response. We must supply the password client id and secret.
     */
    protected function issueToken(string $username, string $password)
    {
        $clientId = env('PASSPORT_PASSWORD_CLIENT_ID');
        $clientSecret = env('PASSPORT_PASSWORD_CLIENT_SECRET');


        if (!$clientId || !$clientSecret) {
            return response()->json(['error' => 'OAuth password client not configured. Run `php artisan passport:client --password` and add PASSPORT_PASSWORD_CLIENT_ID & _SECRET to .env'], 500);
        }


        // Build form parameters similar to an HTTP POST to /oauth/token
        $params = [
            'grant_type' => 'password',
            'client_id' => $clientId,
            'client_secret' => $clientSecret,
            'username' => $username,
            'password' => $password,
            'scope' => '',
        ];


        // Create a PSR-7 ServerRequest using Nyholm
        $psrFactory = $this->psr17Factory;


        // Build URI and server parameters (you may want to set host, scheme etc.)
        $uri = $psrFactory->createUri('/oauth/token');


        // create server request
        $serverRequest = $psrFactory->createServerRequest('POST', $uri, []);


        // add parsed body (form parameters)
        $serverRequest = $serverRequest->withParsedBody($params);


        // Forward to Passport AccessTokenController
        $accessTokenController = app(AccessTokenController::class);


        // AccessTokenController->issueToken() accepts a Psr ServerRequestInterface
        $psrResponse = $accessTokenController->issueToken($serverRequest, new Response());

        return $psrResponse;
    }

    public function refresh(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'refresh_token' => 'required|string',
        ]);


        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }


        $clientId = env('PASSPORT_PASSWORD_CLIENT_ID');
        $clientSecret = env('PASSPORT_PASSWORD_CLIENT_SECRET');


        $params = [
            'grant_type' => 'refresh_token',
            'refresh_token' => $request->refresh_token,
            'client_id' => $clientId,
            'client_secret' => $clientSecret,
            'scope' => '',
        ];


        $psrFactory = $this->psr17Factory;
        $uri = $psrFactory->createUri('/oauth/token');
        $serverRequest = $psrFactory->createServerRequest('POST', $uri, []);
        $serverRequest = $serverRequest->withParsedBody($params);


        $accessTokenController = app(AccessTokenController::class);
        $psrResponse = $accessTokenController->issueToken($serverRequest, new Response());

        return $psrResponse;
    }


    /**
     * Logout: revoke current access token and its refresh tokens
     */
    public function logout(Request $request)
    {
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
}

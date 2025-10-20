<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Laravel\Passport\Passport;
use App\Http\Response\ApiResponse;
use Laravel\Passport\HasApiTokens;
use Illuminate\Support\Facades\Hash;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\Contracts\OAuthenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements OAuthenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public static function createUser(array $attributes){
        $user = self::create($attributes);
        $token = $user->createToken('auth_token')->accessToken;

        return (new ApiResponse)
                ->setMessage('User created see token')
                ->setToken($token)
                ->setData($user->toArray())
                ->returnResponse();

    }

    public static function login(array $attributes)
    {
        $user = self::whereEmail($attributes['email'])->first();
        if (!$user || !Hash::check($attributes['password'], $user->password)){
            return (new ApiResponse)
                    ->setMessage('Unauthorized access')
                    ->returnResponse(401);
        }

        self::logOut($user->email);

        $token = $user->createToken('login_token');
        return (new ApiResponse)
                ->setMessage('User logged in')
                ->setToken($token)
                ->setData($user->toArray())
                ->returnResponse();
    }

    public static function logOut($email)
    {
        $user = self::whereEmail($email)->first();
        $tokens = Passport::token()->whereUserId($user->id)->get();

        // $token->revoke();
        $tokens->each(function ($token){
            $token->revoke();
            // $token->delete();
        });
    }
}

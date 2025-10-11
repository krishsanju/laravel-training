<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Enums\UserRole;
use Illuminate\Support\Facades\Hash;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role'
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
            'role' => UserRole::class,
        ];
    }

    public function  posts(){
        return $this->hasMany(Post::class);
    }


    public function scopeAdminUser($query){
        return $query->where('role', UserRole::fromValue(1)->value);
    }


    public static function createUser(array $data){
        // info($data);
        return self::create([

            'name'=> $data['name'],
            'email'=> $data['email'],
            'password'=> $data['password'],
            // 'role' => $data['role'],
            // 'role' => UserRole::from($data['role'])->value,
            'role'=> UserRole::fromValue((int) $data['role']),
        ]);
    }


    public static function verifyCredentials($email, $password)
    {
        $user = self::where('email', $email)->first();
        $user = self::whereEmail($email)->first();
        // $user = self::whereIsAdmin($is_admin)->first();

        if ($user && Hash::check($password, $user->password)) {
            return $user;
        }

        return null;
    }

    public function getUserAdminAttribute(){
        return $this->role;
        
    }
}

<?php

namespace App\Models;

use App\Enums\ActivityType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UserActivity extends Model
{
    use HasFactory;

    protected $table = 'user_activity';
    protected $fillable = [
        'user_id',
        'login_attempts',
        'password_changes',
        'email_changes',
        'is_fraud',
        'activity_date',
        'activity_type',
        'count',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function checkIfUserIsFraud(User $user)
    {
        $today = today()->toDateString();

        $loginAttempts = self::getActivityCount($user, ActivityType::Login, $today);
        $passwordChanges = self::getActivityCount($user, ActivityType::PasswordChange, $today);

        return ($loginAttempts > 1 || $passwordChanges >3);
    }

    private static function getActivityCount(User $user, $activityType, string $date)
    {
        return $user->userActivities()
                ->whereDate('created_at', '=', $date)
                ->where('activity_type', ActivityType::getDescription($activityType))
                ->count();
    }

    public function incrementLogin(User $user)
    {
        return $this->incrementActivity($user, ActivityType::Login);
    }

    public function incrementPasswordChange(User $user)
    {
        return $this->incrementActivity($user, ActivityType::PasswordChange);
    }

    protected static function incrementActivity(User $user, $activityType)
    {
        $typeString = ActivityType::getDescription($activityType);
        $activity = $user->userActivities()->create([
                'activity_date' => today()->toDateString(),
                'activity_type' => $typeString,
            ]);

        return $activity;
    }
}

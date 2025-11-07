<?php

namespace App\Models;

use App\Enums\ActivityTypeEnum;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UserActivity extends Model
{
    use HasFactory;

    protected $table = 'user_activity';
    protected $fillable = [
        'user_id',
        'activity_type',
        'data',
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

        $loginAttempts = self::getActivityCount($user, ActivityTypeEnum::Login, $today);
        $passwordChanges = self::getActivityCount($user, ActivityTypeEnum::PasswordChange, $today);

        return ($loginAttempts > 5 || $passwordChanges > 3);
    }

    private static function getActivityCount(User $user, $activityTypeEnum, string $date)
    {
        $enumKey = ActivityTypeEnum::getKey($activityTypeEnum);

        return $user->userActivities()
                ->whereDate('created_at', '=', $date)
                ->where('activity_type', $enumKey)
                ->count();

        // return $user->userActivities()->isToday()->withEventType($ActivityTypeEnum)->count(0);
    }

    public function incrementLogin(User $user)
    {
        return $this->incrementActivity($user, ActivityTypeEnum::Login);
    }

    public function incrementPasswordChange(User $user)
    {
        return $this->incrementActivity($user, ActivityTypeEnum::PasswordChange);
    }

    protected static function incrementActivity(User $user, $activityTypeEnum)
    {
        $typeKey = ActivityTypeEnum::getKey($activityTypeEnum);
        $typeDescription = ActivityTypeEnum::getDescription($activityTypeEnum);
        $activity = $user->userActivities()->create([
                'activity_type' => $typeKey,
                'data' => $typeDescription,
            ]);

        return $activity;
    }
}

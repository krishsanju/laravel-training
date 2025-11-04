<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserActivity extends Model
{
    use HasFactory;

    protected $table = 'user_activity';
    protected $fillable = [
        'user_id','login_attempts','password_changes','email_changes','is_fraud','activity_date',
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

    private static function updateUserActivity($user, $column)
    {
        $activity = static::firstOrCreate([
            'user_id' => $user->id,
            'activity_date' => now()->toDateString(),
        ]);
        $activity->increment($column);
        return $activity;
    }
    private function updateFraudStatus(): void
    {
        $isFraud = $this->login_attempts > 5 || $this->password_changes > 3;
        if ($isFraud && !$this->is_fraud) {
            $this->update(['is_fraud' => true]);
        }
    }

    public static function incrementLogin(User $user)
    {
        $activity = self::updateUserActivity($user, 'login_attempts');
        $activity->updateFraudStatus();
        return $activity;
    }
    public static function incrementPasswordChange(User $user): self
    {
        $activity = self::updateUserActivity($user, 'password_changes');
        $activity->updateFraudStatus();
        return $activity;
    }

    public static function isFraud($userId)
    {
        $activity = static::whereUserId($userId)
            ->where('activity_date', now()->toDateString())
            ->first();

        return $activity ? $activity->is_fraud : false;
    }

}

<?php

namespace Database\Factories;

use App\Enums\ActivityTypeEnum;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\UserActivity>
 */
class UserActivityFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $activityValue = collect(ActivityTypeEnum::getValues())->random();

        $activityKey = ActivityTypeEnum::getKey($activityValue);
        $activityDescription = ActivityTypeEnum::getDescription($activityValue);
        $user = User::all();

        return [
            'user_id' => $user->random()->id,
            'activity_type' => $activityKey,
            'data' => $activityDescription,
        ];
    }
}

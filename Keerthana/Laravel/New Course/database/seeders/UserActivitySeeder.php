<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\UserActivity;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserActivitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users  = User::all();
        if($users->isEmpty())
        {
            $this->command->warn("!!! NO USERS FOUND !!!");
            $users = User::factory(5)->create();
        }
        $users->each(function ($user) {
            UserActivity::factory(rand(3, 10))->create([
                'user_id' => $user->id,
            ]);
        });
    }
}

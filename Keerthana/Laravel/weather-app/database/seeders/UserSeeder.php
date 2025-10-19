<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{

    /**
     * Run the database seeds.
    */
    public function run(): void
    {
        // $state = $this->command->argument('state') ?? 'north';
        // (!in_array($state, ['north','south','east','west'])) && $state = 'north';
        $state = 'south';
        User::factory(25)
        ->withState($state)
        ->create();
        
    }
}

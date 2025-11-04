<?php

namespace App\Console\Commands;

use App\Models\UserActivity;
use Illuminate\Console\Command;

class ResetUserActivity extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user-activity:reset';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Reset user activity counters daily';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        UserActivity::query()->update([
            'login_attempts'=> 0,
            'password_changes' => 0,
            'email_changes' => 0,
            'is_fraud' => false,
        ]);
    }
}

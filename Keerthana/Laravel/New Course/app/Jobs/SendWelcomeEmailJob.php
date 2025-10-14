<?php

namespace App\Jobs;

use App\Mail\WelcomeEmail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendWelcomeEmailJob implements ShouldQueue
{
    use Queueable;

    public $user;

    /**
     * Create a new job instance.
     */
    public function __construct($user)
    {
        $this->user = $user;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        info('Job is being processed');
        Mail::to("kksfeb24@gmail.com")->send(new WelcomeEmail($this->user));
    }
}

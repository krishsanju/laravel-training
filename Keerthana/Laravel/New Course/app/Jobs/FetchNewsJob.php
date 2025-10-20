<?php

namespace App\Jobs;

use App\Service\GnewsService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class FetchNewsJob implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        
    }

    /**
     * Execute the job.
     */
    public function handle(GnewsService $gnewsService): void
    {
        $gnewsService->fetchNews();
    }
}

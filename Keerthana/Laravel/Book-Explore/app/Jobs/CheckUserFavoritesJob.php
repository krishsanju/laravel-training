<?php

namespace App\Jobs;

use App\Models\User;
use App\Mail\FavoriteSummaryMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class CheckUserFavoritesJob implements ShouldQueue
{
    use Queueable, Dispatchable, InteractsWithQueue, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $users = User::withCount('favorites')
        ->having('favorites_count', '>', 10)
        ->get();

        info(json_encode($users));

    foreach ($users as $user) {
        Mail::to($user->email)->send(
            new FavoriteSummaryMail($user->favorites_count)
        );
    }
    }
}

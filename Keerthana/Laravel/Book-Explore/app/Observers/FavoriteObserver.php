<?php

namespace App\Observers;

use App\Models\Favorite;
use Illuminate\Support\Facades\Mail;
use App\Mail\NewFavoriteNotification;
use Illuminate\Support\Facades\Log;

class FavoriteObserver
{
    /**
     * Handle the Favorite "created" event.
     */
    public function created(Favorite $favorite): void
    {
        try {
            $user = $favorite->user;

            if ($user && filter_var($user->email, FILTER_VALIDATE_EMAIL)) {
                Mail::to($user->email)
                    ->send(new NewFavoriteNotification($favorite));
            }
        } catch (\Exception $e) {
            Log::error('Failed to send new favorite email: ' . $e->getMessage());
        }
    }

    /**
     * Handle the Favorite "updated" event.
     */
    public function updated(Favorite $favorite): void
    {
        //
    }

    /**
     * Handle the Favorite "deleted" event.
     */
    public function deleted(Favorite $favorite): void
    {
        //
    }

    /**
     * Handle the Favorite "restored" event.
     */
    public function restored(Favorite $favorite): void
    {
        //
    }

    /**
     * Handle the Favorite "force deleted" event.
     */
    public function forceDeleted(Favorite $favorite): void
    {
        //
    }
}

<?php

namespace App\Listeners;

use App\Events\PostCreateEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class PostCreateListener
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(PostCreateEvent $event): void
    {
        dd('listener called  '. $event->user);
    }
}

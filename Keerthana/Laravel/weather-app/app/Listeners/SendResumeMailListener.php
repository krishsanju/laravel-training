<?php

namespace App\Listeners;

use App\Mail\SendResumeMail;
use App\Events\SendResumeMailEvent;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendResumeMailListener
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
    public function handle(SendResumeMailEvent $event): void
    {
        info(json_encode($event));
        Mail::to($event->email)->send(new SendResumeMail($event->resumePath));
    }
}

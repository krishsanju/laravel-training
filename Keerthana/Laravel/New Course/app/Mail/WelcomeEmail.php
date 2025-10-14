<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class WelcomeEmail extends Mailable
{
    use Queueable, SerializesModels, Dispatchable;
    public $user;

    /**
     * Create a new message instance.
     */
    public function __construct($user)
    {
        info('welcome email constructor loaded');
        $this->user = $user;
    }

    /**
     * Get the message envelope.
     */
    // public function envelope(): Envelope
    // {
    //     return new Envelope(
    //         subject: 'Welcome Email',
    //     );
    // }

    // /**
    //  * Get the message content definition.
    //  */
    public function content(): Content
    {
        info('welcome email view loaded');

        return new Content(
            view: 'welcome',
        );
    }

    //   public function build()
    // {
    //     return $this->subject('Your Order Has Been Shipped')
    //                 ->view('welcome')
    //                 ->with(['order' => 'order1']);
    // }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    // public function attachments(): array
    // {
    //     return [];
    // }
}

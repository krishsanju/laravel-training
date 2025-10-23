<?php

declare(strict_types=1);
namespace App\PhpUnitTesting\TestDouble;

class NotificationService
{
    public function __construct(private Mailer $mailer)
    {
        $this->mailer = $mailer;
    }
    public function sendNotification(string $recipient_email, string $message): bool
    {
        // $mailer = new Mailer;

        $subject = 'New Notification';

        return $this->mailer->sendEmail($recipient_email, $subject, $message);
    }
}

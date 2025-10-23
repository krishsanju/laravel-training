<?php

use PHPUnit\Framework\TestCase;
use App\PhpUnitTesting\TestDouble\Mailer;
use App\PhpUnitTesting\TestDouble\NotificationService;

final class NotificationServiceTest extends TestCase
{
    public function testNotificationIsSent(): void
    {
        // $service = new NotificationService;

//TEST DOUBLES
        // $mailer = new Mailer();
        // $service = new NotificationService($mailer);

//TEST STUBS
        $mailer = $this->createStub(Mailer::class);
        $mailer->method('sendEmail')
                ->willReturn(true);
        $service = new NotificationService($mailer);
        
        $this->assertTrue($service->sendNotification('keerh@gamil.com', 'hello'));
    }

    public function testSendThrowsException(): void
    {
        $mailer = $this->createStub(Mailer::class);
        $mailer->method('sendEmail')
                ->willThrowException(new RuntimeException('SMTP server down'));

        $service = new NotificationService($mailer);
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('SMTP server down');
        $service->sendNotification('keerh@gamil.com', 'hello');
    }
}
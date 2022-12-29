<?php

declare(strict_types=1);

namespace App\Tests\MessagingProvider\Pushy;

use App\DTO\NotificationFormData;
use App\MessagingProvider\Pushy\NotificationService;
use App\MessagingProvider\Pushy\PushyHttpClient;
use PHPUnit\Framework\TestCase;

final class NotificationServiceTest extends TestCase
{
    private NotificationService $sut;

    //TODO: does this test makes sense? There are no behaviors
    public function testSendSuccessful(): void
    {
        $notification = new NotificationFormData();

        $result = $this->sut->send($notification);

        $this->assertTrue($result);
    }

    protected function setUp(): void
    {
        $pushyClient = $this->createStub(PushyHttpClient::class);
        $this->sut = new NotificationService($pushyClient);
    }
}

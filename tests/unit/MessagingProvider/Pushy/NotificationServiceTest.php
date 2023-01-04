<?php

declare(strict_types=1);

namespace App\Tests\unit\MessagingProvider\Pushy;

use App\DTO\NotificationFormData;
use App\MessagingProvider\Pushy\NotificationService;
use App\MessagingProvider\Pushy\PushyHttpClient;
use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\ParameterBag\ContainerBagInterface;

final class NotificationServiceTest extends TestCase
{
    private NotificationService $sut;

    //TODO: does this test makes sense? There are no behaviors
    public function testSendSuccessful(): void
    {
        $notification = new NotificationFormData();
        $notification->setNotificationId('dummy');
        $notification->setMessage('dummy');

        $result = $this->sut->send($notification, ['pushy-recipient' => 'dummy']);

        $this->assertTrue($result);
    }

    protected function setUp(): void
    {
        $pushyClient = $this->createStub(PushyHttpClient::class);
        $params = $this->createStub(ContainerBagInterface::class);
        $this->sut = new NotificationService($pushyClient, $params);
    }
}

<?php

declare(strict_types=1);

namespace App\MessagingProvider\Pushy;

use App\DTO\NotificationFormData;
use App\Form\FieldType;
use App\MessagingProvider\NotificationServiceInterface;
use App\MessagingProvider\ProviderConfigItem;
use App\MessagingProvider\UnableToSendNotificationException;
use Symfony\Component\DependencyInjection\ParameterBag\ContainerBagInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

final class NotificationService implements NotificationServiceInterface
{
    public const PROVIDER_NAME = 'Pushy';

    public function __construct(
        private readonly PushyHttpClient $client,
        private readonly ContainerBagInterface $params,
    )
    {}

    public function getProviderName(): string
    {
        return self::PROVIDER_NAME;
    }

    /**
     * @param array<string, string> $config
     *
     * @throws UnableToSendNotificationException
     * @throws TransportExceptionInterface
     */
    public function send(NotificationFormData $notificationFormData, array $config): bool
    {
        // Optional push notification options (such as iOS notification fields) -> should be replaced with some DTO
        $options = [
            'notification' => [
                'badge' => 1,
                'sound' => 'ping.aiff',
                'title' => 'Test Notification',
                'body' => "{$notificationFormData->getMessage()} \xE2\x9C\x8C",
            ]
        ];

        $this->client->sendPushNotification(
            $notificationFormData->getMessage(),
            [$config['pushy-recipient']],
            $options,
        );

        return true;
    }

    public function getConfigFields(): array
    {
        return [
            new ProviderConfigItem(FieldType::Text, 'pushy-recipient', 'Pushy device ID or topic', 90),
        ];
    }
}

<?php

declare(strict_types=1);

namespace App\MessagingProvider;

use App\DTO\NotificationFormData;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

interface NotificationServiceInterface
{
    public function getProviderName(): string;

    public function isEnabled(): bool;

    /**
     * @throws UnableToSendNotificationException
     * @throws TransportExceptionInterface
     */
    public function send(NotificationFormData $notificationFormData): bool; //TODO: use some result class or Either<Fail,Result>

    /** @return ProviderConfigItem[] */
    public function getConfigFields(): array;
}

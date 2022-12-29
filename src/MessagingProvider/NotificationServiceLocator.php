<?php

declare(strict_types=1);

namespace App\MessagingProvider;

use App\DTO\NotificationFormData;
use Psr\Log\LoggerInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

final class NotificationServiceLocator
{
    /** @var NotificationServiceInterface[] $serviceProviders */
    public function __construct(
        private readonly iterable $serviceProviders,
        private readonly LoggerInterface $logger,
    )
    {}

    public function sendWithFallback(NotificationFormData $notificationData): void
    {
        foreach ($this->serviceProviders as $service) {
            if (!$service->isEnabled()) {
                continue;
            }
            try {
                if ($service->send($notificationData)) {
                    $this->logger->info('Successfully sent notification using {provider}', ['provider' => $service->getProviderName()]);
                    return;
                }
            } catch (UnableToSendNotificationException $ex) {
                $this->logger->warning($ex->getMessage(), ['error' => $ex->content]);
            } catch (TransportExceptionInterface $ex) {
                $this->logger->warning('Unable to send notification using {provider} because {exception}', [
                    'provider' => $service->getProviderName(),
                    'exception' => $ex->getMessage(),
                ]);
            }
        }
    }
}

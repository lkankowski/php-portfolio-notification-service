<?php

declare(strict_types=1);

namespace App\MessagingProvider;

use App\DTO\NotificationFormData;
use Psr\Log\LoggerInterface;
use Symfony\Component\DependencyInjection\Argument\RewindableGenerator;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

final class NotificationServiceResolver
{
    /** @var NotificationServiceInterface[] $serviceProviders */
    public function __construct(
        private readonly iterable $serviceProviders,
        private readonly LoggerInterface $logger,
    )
    {}

    /** @param array<string, string> $config */
    public function sendWithFallback(NotificationFormData $notificationData, array $config): bool
    {
        $services = $this->getOrderedServices($config);

        foreach ($services as $service) {
            try {
                if ($service->send($notificationData, $config)) {
                    $this->logger->info('Successfully sent notification using {provider}', ['provider' => $service->getProviderName()]);
                    return true;
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

        return false;
    }

    /** @param array<string, string> $config */
    private function getOrderedServices(array $config): array
    {
        $enabledServices = [];
        foreach ($this->serviceProviders as $service) {
            $configKey = $service->getConfigFields()[0]->id . '-enabled';
            if (!isset($config[$configKey]) || $config[$configKey]) {
                $enabledServices[] = $service;
            }
        }
        usort($enabledServices, fn(NotificationServiceInterface $service1, NotificationServiceInterface $service2) =>
            $config[$service1->getConfigFields()[0]->id . '-priority'] < $config[$service2->getConfigFields()[0]->id . '-priority']
        );

        return $enabledServices;
    }
}

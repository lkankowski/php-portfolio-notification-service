<?php

declare(strict_types=1);

namespace App\MessagingProvider\Mailgun;

use App\DTO\NotificationFormData;
use App\MessagingProvider\NotificationServiceInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ContainerBagInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

final class NotificationService implements NotificationServiceInterface
{
    public const PROVIDER_NAME = 'Mailgun';

    public function __construct(
        private readonly MailerInterface $mailer,
        private readonly ContainerBagInterface $params,
    )
    {}

    public function getProviderName(): string
    {
        return self::PROVIDER_NAME;
    }

    public function isEnabled(): bool
    {
        return $this->params->get('app.mailer.enabled');
    }

    public function send(NotificationFormData $notificationFormData): bool
    {
        $email = (new Email())
            ->from($this->params->get('app.mailer.sender'))
            ->to($notificationFormData->getEmail())
            ->subject($this->params->get('app.mailer.subject'))
            ->text($notificationFormData->getMessage());

        $this->mailer->send($email);

        return true;
    }
}

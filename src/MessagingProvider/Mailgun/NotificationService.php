<?php

declare(strict_types=1);

namespace App\MessagingProvider\Mailgun;

use App\DTO\NotificationFormData;
use App\Form\FieldType;
use App\MessagingProvider\NotificationServiceInterface;
use App\MessagingProvider\ProviderConfigItem;
use App\MessagingProvider\UnableToSendNotificationException;
use Symfony\Component\DependencyInjection\ParameterBag\ContainerBagInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

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

    /**
     * @param array<string, string> $config
     */
    public function send(NotificationFormData $notificationFormData, array $config): bool
    {
        $email = (new Email())
            ->from($this->params->get('app.mailer.sender'))
            ->to($config['email'])
            ->subject($this->params->get('app.mailer.subject'))
            ->text($notificationFormData->getMessage());

        $this->mailer->send($email);

        return true;
    }

    public function getConfigFields(): array
    {
        return [
            new ProviderConfigItem(FieldType::Email, 'email', 'Email', 50),
        ];
    }
}

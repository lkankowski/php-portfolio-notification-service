<?php

declare(strict_types=1);

namespace App\MessagingProvider;

final class UnableToSendNotificationException extends \Exception
{
    public function __construct(string $providerName, int $code, public readonly string $content)
    {
        parent::__construct(\sprintf('Unable to send notification using %s (status code: %d)', $providerName, $code), $code);
    }
}

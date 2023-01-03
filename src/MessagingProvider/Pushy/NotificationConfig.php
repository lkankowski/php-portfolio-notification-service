<?php

declare(strict_types=1);

namespace App\MessagingProvider\Pushy;

use App\Form\FieldType;
use App\MessagingProvider\ProviderConfigItem;
use App\MessagingProvider\ProviderConfigurationInterface;

final class NotificationConfig implements ProviderConfigurationInterface
{
    public function getConfigFields(): array
    {
        return [
            new ProviderConfigItem(FieldType::Text, 'pushy-recipient', 'Pushy device ID or topic'),
        ];
    }
}

<?php

declare(strict_types=1);

namespace App\MessagingProvider;

use App\Form\FieldType;

interface ProviderConfigurationInterface
{
    /** @return ProviderConfigItem[] */
    public function getConfigFields(): array;
}

<?php

declare(strict_types=1);

namespace App\MessagingProvider;

use App\Form\FieldType;

final class ProviderConfigItem
{
    public function __construct(
        public readonly FieldType $type,
        public readonly string $id,
        public readonly string $description,
        public readonly int $defaultPriority,
    )
    {}
}

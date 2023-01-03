<?php

declare(strict_types=1);

namespace App\MessagingProvider;


use App\Form\FieldType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

final class ProviderConfigTypeMapper
{
    /** @return class-string */
    public static function mapToForm(ProviderConfigItem $configItem): string
    {
        return match($configItem->type) {
            FieldType::Email => EmailType::class,
            FieldType::PhoneNumber => TelType::class,
            FieldType::Text => TextType::class,
        };
    }
}

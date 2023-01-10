<?php

declare(strict_types=1);

namespace App\Eshop\Application;

final class ProductData implements \JsonSerializable
{
    public function __construct(
        public readonly int $id,
        public readonly string $title,
        public readonly int $price,
        public readonly string $currency,
    ) {}

    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'price' => $this->price,
            'currency' => $this->currency,
        ];
    }
}

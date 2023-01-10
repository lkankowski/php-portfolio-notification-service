<?php

declare(strict_types=1);

namespace App\Eshop\Application;

final class PagerData implements \JsonSerializable
{
    public function __construct(
        public readonly int $first,
        public readonly int $last,
        public readonly int $previous,
        public readonly int $next,
    ) {}

    public function jsonSerialize(): array
    {
        return [
            'first' => $this->first,
            'last' => $this->last,
            'previous' => $this->previous,
            'next' => $this->next,
        ];
    }
}

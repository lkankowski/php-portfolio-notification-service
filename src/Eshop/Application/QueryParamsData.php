<?php

declare(strict_types=1);

namespace App\Eshop\Application;

final class QueryParamsData
{
    public function __construct(
        public readonly int $offset,
        public readonly int $limit,
    ) {}
}

<?php

namespace App\DTO;

class UserChannelsData
{
    public function __construct(
        public readonly int $userId,
        public readonly string $configJson,
    )
    {}
}

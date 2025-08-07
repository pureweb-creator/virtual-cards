<?php

namespace App\DTO;

final readonly class VCardDTO
{
    public function __construct(
        public int $userId
    )
    {}
}

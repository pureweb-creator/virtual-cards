<?php

namespace App\DTO;

final readonly class UserLoginDTO
{
    public function __construct(
        public string $email,
        public string $password,
        public ?bool $remember_me=null
    )
    {}
}

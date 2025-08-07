<?php

namespace App\DTO;

final readonly class UserRegisterDTO
{
    public function __construct(
        public string $first_name,
        public string $email,
        public string $password,
        public ?bool $remember_me=null
    )
    {}
}

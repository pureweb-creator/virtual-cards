<?php

namespace App\DTO;

readonly class UserRegisterDTO
{
    public function __construct(
        public string $first_name,
        public string $email,
        public string $password,
        public ?string $remember_me=null
    )
    {}
}

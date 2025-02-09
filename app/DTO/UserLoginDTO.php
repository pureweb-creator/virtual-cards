<?php

namespace App\DTO;

readonly class UserLoginDTO
{
    public function __construct(
        public string $email,
        public string $password,
        public ?string $remember_me=null
    )
    {}
}

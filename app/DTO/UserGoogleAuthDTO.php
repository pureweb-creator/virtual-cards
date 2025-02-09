<?php

namespace App\DTO;

readonly class UserGoogleAuthDTO
{
    public function __construct(
        public string $id,
        public string $token,
        public string $refresh_token,
        public string $first_name,
        public string $email,
        public string $avatar
    )
    {}
}

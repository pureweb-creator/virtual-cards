<?php

namespace App\DTO;

final readonly class UserAvatarDTO
{
    public function __construct(
        public string $base64ImgString
    )
    {}
}

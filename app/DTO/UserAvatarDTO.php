<?php

namespace App\DTO;

class UserAvatarDTO
{
    public function __construct(
        public string $base64ImgString
    )
    {}
}

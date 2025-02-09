<?php

namespace App\DTO;

readonly class SocialLinkDTO
{
    public function __construct(
        public ?string $telegram,
        public ?string $facebook,
        public ?string $instagram,
        public ?string $whatsapp,
        public ?string $twitter,
        public ?string $telegram_hidden=null,
        public ?string $facebook_hidden=null,
        public ?string $instagram_hidden=null,
        public ?string $whatsapp_hidden=null,
        public ?string $twitter_hidden=null,
    )
    {}
}

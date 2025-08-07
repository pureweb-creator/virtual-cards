<?php

namespace App\DTO;

final readonly class SocialLinkDTO
{
    public function __construct(
        public ?string $telegram,
        public ?string $facebook,
        public ?string $instagram,
        public ?string $whatsapp,
        public ?string $twitter,
        public ?bool $telegram_hidden=null,
        public ?bool $facebook_hidden=null,
        public ?bool $instagram_hidden=null,
        public ?bool $whatsapp_hidden=null,
        public ?bool $twitter_hidden=null,
    )
    {}
}

<?php

namespace App\DTO;

class SocialLinkDTO
{
    public function __construct(
        public string|null $telegram,
        public string|null $facebook,
        public string|null $instagram,
        public string|null $whatsapp,
        public string|null $twitter,
        public string|null $telegram_hidden=null,
        public string|null $facebook_hidden=null,
        public string|null $instagram_hidden=null,
        public string|null $whatsapp_hidden=null,
        public string|null $twitter_hidden=null,
    )
    {}
}

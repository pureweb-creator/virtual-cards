<?php

namespace App\DTO;

readonly class LocationDTO
{
    public function __construct(
        public ?string $country,
        public ?string $city,
        public ?string $street,
        public ?string $postcode
    )
    {}
}

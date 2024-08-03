<?php

namespace App\DTO;

class LocationDTO
{
    public function __construct(
        public string|null $country=null,
        public string|null $city=null,
        public string|null $street=null,
        public string|null $postcode=null
    )
    {}
}

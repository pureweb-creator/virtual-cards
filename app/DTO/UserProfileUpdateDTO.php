<?php

namespace App\DTO;

readonly class UserProfileUpdateDTO
{
    public function __construct(
        public string  $first_name,
        public ?string $last_name,
        public ?string $home_tel,
        public ?string $work_tel,
        public ?string $website,
        public ?string $company,
        public ?string $job_title
    )
    {}
}

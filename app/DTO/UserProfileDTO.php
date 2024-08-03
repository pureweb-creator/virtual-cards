<?php

namespace App\DTO;

class UserProfileDTO
{
    public function __construct(
        public string|null $google_id=null,
        public string|null $google_token=null,
        public string|null $google_refresh_token=null,
        public string|null $first_name=null,
        public string|null $last_name=null,
        public string|null $home_tel=null,
        public string|null $work_tel=null,
        public string|null $website=null,
        public string|null $avatar=null,
        public string|null $email=null,
        public string|null $company=null,
        public string|null $job_title=null,
        public string|null $user_hash=null,
        public bool|null $is_subscribed=null,
        public string|null $trial_expiration_time=null,
        public string|null $expiration_time=null,
        public string|null $password=null,
        public string|bool|null $remember_me=null,
    )
    {}
}

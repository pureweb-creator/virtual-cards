<?php

namespace App\DTO;

class PaymentDTO
{
    public function __construct(
        public ?float $amount,
        public ?string $currency,
        public ?string $description,
        public ?string $language,
        public ?string $orderId,
        public ?string $interval,
        public ?string $period,
        public ?string $email,
        public ?string $userId
    )
    {}
}

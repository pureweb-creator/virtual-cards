<?php

namespace App\DTO;

class PaymentDTO
{
    public function __construct(
        public float|null $amount,
        public string|null $currency,
        public string|null $description,
        public string|null $language,
        public string|null $orderId,
        public string|null $interval,
        public string|null $period,
        public string|null $email,
        public string|null $userId
    )
    {}
}

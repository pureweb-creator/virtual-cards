<?php

namespace App\DTO;

class PaymentDTO
{
    public function __construct(
        public float|null $amount = null,
        public string|null $currency = null,
        public string|null $description = null,
        public string|null $language = null,
        public string|null $orderId = null,
        public string|null $interval = null,
        public string|null $period = null,
        public string|null $email = null,
        public string|null $userId = null
    )
    {}
}

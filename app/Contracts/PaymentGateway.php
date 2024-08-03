<?php

namespace App\Contracts;

use App\DTO\PaymentDTO;

interface PaymentGateway
{
    public function init(PaymentDTO $dto);
    public function getStatus($orderId);
    public function confirm();
}

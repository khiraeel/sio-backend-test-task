<?php

namespace App\Interface;

use Money\Money;

interface PaymentProcessorInterface
{
    public function pay(Money $money): void;
}


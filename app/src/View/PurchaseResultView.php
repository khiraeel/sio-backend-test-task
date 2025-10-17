<?php

namespace App\View;

use Money\Money;

readonly class PurchaseResultView
{
    public function __construct() {}

    public function getData(): array
    {
        return [
            'result' => 'Payment was successful',
        ];
    }
}

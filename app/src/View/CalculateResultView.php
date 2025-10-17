<?php

namespace App\View;

use Money\Money;

readonly class CalculateResultView
{
    public function __construct(private Money $calculatedResult)
    {
    }

    public function getData(): array
    {
        return [
            'currency' => $this->calculatedResult->getCurrency(),
            'amount' => $this->calculatedResult->getAmount(),
        ];
    }
}

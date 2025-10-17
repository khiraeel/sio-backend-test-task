<?php

declare(strict_types=1);

namespace App\Service;

class TaxNumberParseService
{
    public function __construct() {
    }

    public function getCountryCode(string $taxNumber): ?string
    {
        return mb_strtoupper(substr($taxNumber, 0, 2));
    }
}

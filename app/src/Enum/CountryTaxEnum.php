<?php

declare(strict_types=1);

namespace App\Enum;

enum CountryTaxEnum: string
{
    case GERMANY = '19';
    case ITALY = '22';
    case FRANCE = '20';
    case GREECE = '24';
}

<?php

declare(strict_types=1);

namespace App\Entity\ValueObject;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\Embedded;
use Money\Currency;
use Money\Money;

#[ORM\Embeddable]
final class Price
{
    #[Embedded(class: Money::class)]
    private Money $value;

    public function __construct(
        int|string $value,
        string $currency = 'EUR'
    ) {
        $this->value = new Money($value, new Currency($currency));
    }

    public static function eur(int $amount): self
    {
        return new self($amount, 'EUR');
    }

    public function getMoney(): Money
    {
        return $this->value;
    }

    public function getCurrency(): Currency
    {
        return $this->value->getCurrency();
    }

    public function getAmount(): string
    {
        return $this->value->getAmount();
    }
}

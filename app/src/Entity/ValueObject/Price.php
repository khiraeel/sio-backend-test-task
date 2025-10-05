<?php

namespace App\Entity\ValueObject;

class Price
{
    private float $value;

    public function __construct(float $value)
    {
        $this->value = round($value, 1);
    }

    public function getValue(): float
    {
        return $this->value;
    }

    public function jsonSerialize(): float
    {
        return $this->value;
    }

    public function __toString(): string
    {
        return (string)$this->value;
    }

}

<?php

namespace App\Entity\ValueObject;

use App\Enum\CouponTypeEnum;
use App\Exceptions\InvalidArgumentException;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Embeddable]
class CouponDiscount
{
    #[ORM\Column(type: Types::STRING, enumType: CouponTypeEnum::class)]
    private CouponTypeEnum $type;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2)]
    private float $value;

    public function __construct(CouponTypeEnum $type, float $value)
    {
        if ($type === CouponTypeEnum::PERCENT && ($value < 0 || $value > 100)) {
            throw new InvalidArgumentException("Percentage discount must be between 0 and 100");
        }

        $this->type = $type;
        $this->value = round($value, 1);
    }
    public function getType(): CouponTypeEnum
    {
        return $this->type;
    }

    public function getValue(): float
    {
        return $this->value;
    }

    public function __toString(): string
    {
        return (string) $this->value;
    }
}

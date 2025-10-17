<?php

declare(strict_types=1);

namespace App\Entity\ValueObject;

use App\DBAL\Type\CouponTypeEnum;
use App\Enum\CouponTypeEnum as EnumCouponType;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use InvalidArgumentException;
use Money\Money;

#[ORM\Embeddable]
class CouponDiscount
{
    #[ORM\Column(type: CouponTypeEnum::COUPON_TYPE)]
    private EnumCouponType $type;

    #[ORM\Embedded(class: Price::class, columnPrefix: 'fixed_')]
    private ?Price $fixedValue = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2, nullable: true)]
    private ?float $percentValue = null;

    public function __construct(EnumCouponType $type, Price|float $value)
    {
        if($value instanceof Price) {
            $this->fixedValue = $value;
        } else if ($this->isTypePercent($type) && $this->isValidPercentValue($value) ) {
            $this->percentValue = $value;
        } else {
            throw new InvalidArgumentException('Percentage discount must be between 0 and 100');
        }

        $this->type = $type;
    }

    public function isTypePercent(EnumCouponType $type): bool
    {
        return $type === EnumCouponType::PERCENT;
    }

    public function isValidPercentValue(float $value): bool
    {
        return $value >= 0 && $value <= 100;
    }

    public function getType(): EnumCouponType
    {
        return $this->type;
    }

    public function getValue(): string|float
    {
        return $this->type === EnumCouponType::PERCENT ? $this->percentValue : $this->getMoneyValue();
    }

    public function getValueBySum(Money $sum): Money
    {
        if($this->type === EnumCouponType::FIXED) {
            return $this->fixedValue->getMoney();
        }

        $percentUnit = $this->getPercentUnit($sum);
        return $percentUnit->multiply( (string)$this->percentValue );
    }

    public function getPercentUnit(Money $money): Money
    {
        return $money->divide(100);
    }

    public function getMoneyValue(): ?string
    {
        return $this->fixedValue->getAmount();
    }

}

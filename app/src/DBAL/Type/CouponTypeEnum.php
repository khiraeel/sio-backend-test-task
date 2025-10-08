<?php

namespace App\DBAL\Type;

use App\Enum\CouponTypeEnum as CouponTypes;
use Doctrine\DBAL\Platforms\AbstractPlatform;

class CouponTypeEnum extends EnumType
{
    public const COUPON_TYPE = 'coupon_type';

    public function getSQLDeclaration(array $fieldDeclaration, AbstractPlatform $platform): string
    {
        return self::COUPON_TYPE;
    }

    public function convertToPHPValue(mixed $value, AbstractPlatform $platform): mixed
    {
        if ($value === null) {
            return null;
        }

        return CouponTypes::from($value);
    }

    public function convertToDatabaseValue(mixed $value, AbstractPlatform $platform): ?string
    {
        if ($value === null) {
            return null;
        }

        if (!$value instanceof CouponTypes) {
            throw new \InvalidArgumentException(sprintf(
                'Expected %s, got %s',
                CouponTypes::class,
                get_debug_type($value)
            ));
        }

        return $value->value;
    }

    public function getName(): string
    {
        return self::COUPON_TYPE;
    }
}

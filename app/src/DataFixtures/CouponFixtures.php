<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\Coupon;
use App\Entity\ValueObject\CouponDiscount;
use App\Entity\ValueObject\Price;
use App\Enum\CouponTypeEnum;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Throwable;

class CouponFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $coupons = [
            ['code' => 'P10', 'name' => '10% discount', 'discount_type' => CouponTypeEnum::PERCENT, 'discount_value' => 10.0 ],
            ['code' => 'P50', 'name' => '50% discount', 'discount_type' => CouponTypeEnum::PERCENT, 'discount_value' => 50.0 ],
            ['code' => 'P100', 'name' => '100% discount', 'discount_type' => CouponTypeEnum::PERCENT, 'discount_value' => 100.0 ],
            ['code' => 'D25', 'name' => 'Fixed discount 25 EUR', 'discount_type' => CouponTypeEnum::FIXED, 'discount_value' => Price::eur(2500) ],
            ['code' => 'D75', 'name' => 'Fixed discount 75 EUR', 'discount_type' => CouponTypeEnum::FIXED, 'discount_value' => Price::eur(7500) ],
            ['code' => 'D500', 'name' => "big jackpot", 'discount_type' => CouponTypeEnum::FIXED, 'discount_value' => Price::eur(50000) ],
        ];

        foreach ($coupons as $data) {
            $coupon = new Coupon(
                $data['code'],
                $data['name'],
                new CouponDiscount(
                    $data['discount_type'],
                    $data['discount_value']),
            );

            $manager->persist($coupon);

        }

        $manager->flush();
    }
}

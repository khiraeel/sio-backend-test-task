<?php

namespace App\DataFixtures;

use App\Entity\Coupon;
use App\Entity\ValueObject\CouponDiscount;
use App\Enum\CouponTypeEnum;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CouponFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $coupons = [
            ['code' => 'P10', 'name' => "10% discount", 'discount' => new CouponDiscount(CouponTypeEnum::PERCENT, 10.0)],
            ['code' => 'P50', 'name' => "50% discount", 'discount' => new CouponDiscount(CouponTypeEnum::PERCENT, 50.0)],
            ['code' => 'P100', 'name' => "100% discount", 'discount' => new CouponDiscount(CouponTypeEnum::PERCENT, 100.0)],
            ['code' => 'D25', 'name' => "Fixed discount 25 EUR", 'discount' => new CouponDiscount(CouponTypeEnum::FIXED, 25.0)],
            ['code' => 'D75', 'name' => "Fixed discount 75 EUR", 'discount' => new CouponDiscount(CouponTypeEnum::FIXED, 75.0)],
            ['code' => 'D500', 'name' => "big jackpot", 'discount' => new CouponDiscount(CouponTypeEnum::FIXED, 500.0)],
        ];

        foreach ($coupons as $data) {
            $coupon = new Coupon(
                $data['code'],
                $data['name'],
                $data['discount']
            );
            $manager->persist($coupon);
        }

        $manager->flush();
    }
}

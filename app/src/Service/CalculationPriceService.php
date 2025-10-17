<?php

declare(strict_types=1);

namespace App\Service;

use App\DTO\CalculationPriceRequestDto;
use App\Entity\Coupon;
use App\Entity\Product;
use App\Enum\CountryTaxEnum;
use App\Exceptions\CountryNotFoundException;
use App\Exceptions\LogicException;
use App\Exceptions\ProductNotFoundException;
use App\Repository\CouponRepository;
use App\Repository\ProductRepository;
use App\Enum\CountryEnum;
use Money\Money;

class CalculationPriceService
{
    public function __construct(
        private ProductRepository $productRepository,
        private CouponRepository $couponRepository,
        private TaxNumberParseService $taxNumberParseService
    ) {
    }

    /**
     * @throws LogicException
     * @throws ProductNotFoundException
     * @throws CountryNotFoundException
     */
    public function calculatePrice(CalculationPriceRequestDto $requestDto): Money
    {
        $product = $this->productRepository->getById($requestDto->product);
        if(!$product instanceof Product) {
            throw new ProductNotFoundException('Product by id ' . $requestDto->product . ' not found');
        }

        $countryTaxCode = $this->taxNumberParseService->getCountryCode($requestDto->taxNumber);
        $countryName = CountryEnum::tryFrom($countryTaxCode);
        if( $countryName === null) {
            throw new CountryNotFoundException('Country with code ' . $countryTaxCode . ' not found');
        }

        $coupon = $this->couponRepository->getByCode($requestDto->couponCode);

        $price = $product->getPrice();
        $taxValue = CountryTaxEnum::{$countryName->name}->value;

        return $this->sumProductPrice($price->getMoney(), $taxValue, $coupon);
    }

    public function sumProductPrice(Money $price, string $taxValue, ?Coupon $coupon = null): Money
    {
        $result = $price;

        if($coupon instanceof Coupon) {
            $couponDiscount = $coupon->getDiscount();
            $discountValue = $couponDiscount->getValueBySum($price);

            if($discountValue->greaterThanOrEqual($price)) {
                throw new LogicException('Discount is greater than the price');
            }

            $result = $price->subtract($discountValue);
        }

        $taxPercentUnit = $result->divide(100);
        $taxSum = $taxPercentUnit->multiply($taxValue);

        return $result->add($taxSum);
    }
}

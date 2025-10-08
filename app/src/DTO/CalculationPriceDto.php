<?php

namespace App\DTO;

use App\Entity\Coupon;
use App\Entity\Product;
use Symfony\Component\Validator\Constraints as Assert;

readonly class CalculationPriceDto
{
    #[Assert\NotBlank]
    public Product $product;
    #[Assert\NotBlank]
    public string $taxNumber;
    #[Assert\NotBlank]
    public Coupon $coupon;

    public function __construct(
        Product $product,
        string $taxNumber,
        Coupon $coupon
    ) {
        $this->product = $product;
        $this->taxNumber = $taxNumber;
        $this->coupon = $coupon;
    }
}

<?php

declare(strict_types=1);

namespace App\DTO;

use App\Component\Validator\TaxNumber as TaxNumberConstraint;
use App\Interface\JsonBodyDtoRequestInterface;
use Symfony\Component\Validator\Constraints as Assert;

readonly class PurchaseRequestDto implements JsonBodyDtoRequestInterface
{
    #[Assert\NotBlank]
    #[Assert\PositiveOrZero]
    public int $product;

    #[Assert\NotBlank]
    #[TaxNumberConstraint]
    public string $taxNumber;

    #[Assert\NotBlank]
    public string $paymentProcessor;

    #[Assert\Type('string')]
    #[Assert\Length(max: 50)]
    public ?string $couponCode;

    public function __construct(
        int $product,
        string $taxNumber,
        string $paymentProcessor,
        string $couponCode = null
    ) {
        $this->product = $product;
        $this->taxNumber = $taxNumber;
        $this->paymentProcessor = $paymentProcessor;
        $this->couponCode = $couponCode;
    }
}

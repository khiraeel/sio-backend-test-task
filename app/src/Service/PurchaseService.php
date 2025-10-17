<?php

declare(strict_types=1);

namespace App\Service;

use App\DTO\CalculationPriceRequestDto;
use App\DTO\PurchaseRequestDto;
use App\Exceptions\CountryNotFoundException;
use App\Exceptions\LogicException;
use App\Exceptions\ProductNotFoundException;
use App\Factory\PaymentProcessFactory;
use App\Enum\PaymentProcessorType;

class PurchaseService
{
    public function __construct(
        private CalculationPriceService $calculationPriceService,
        private PaymentProcessFactory $paymentProcessFactory,
    ) {
    }

    /**
     * @throws LogicException
     * @throws ProductNotFoundException
     * @throws CountryNotFoundException
     */
    public function makePurchase(PurchaseRequestDto $requestDto): void
    {
        $calculationPriceDto = new CalculationPriceRequestDto(
            $requestDto->product,
            $requestDto->taxNumber,
            $requestDto->couponCode,
        );

        $price = $this->calculationPriceService->calculatePrice($calculationPriceDto);

        $paymentType = PaymentProcessorType::tryFrom($requestDto->paymentProcessor);

        $paymentProcessor = $this->paymentProcessFactory->create($paymentType);

        $paymentProcessor->pay($price);
    }
}

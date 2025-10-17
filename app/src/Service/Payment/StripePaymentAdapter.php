<?php

namespace App\Service\Payment;

use App\Exceptions\PaymentFailedException;
use App\Interface\PaymentProcessorInterface;
use Systemeio\TestForCandidates\PaymentProcessor\StripePaymentProcessor;
use Money\Money;

class StripePaymentAdapter implements PaymentProcessorInterface
{
    private StripePaymentProcessor $paymentProcessor;

    public function  __construct(
        StripePaymentProcessor $paymentProcessor
    ) {
        $this->paymentProcessor = $paymentProcessor;
    }

    /**
     * @throws PaymentFailedException
     */
    public function pay(Money $money): void
    {
        $float = (float)$money->getAmount();

        $paymentResult =  $this->paymentProcessor->processPayment($float);
        if(!$paymentResult) {
            throw new PaymentFailedException('Stripe payment failed');
        }
    }
}

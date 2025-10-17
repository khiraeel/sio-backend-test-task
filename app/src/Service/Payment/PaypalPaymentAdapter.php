<?php

namespace App\Service\Payment;

use App\Exceptions\PaymentFailedException;
use App\Interface\PaymentProcessorInterface;
use Systemeio\TestForCandidates\PaymentProcessor\PaypalPaymentProcessor;
use Money\Money;

class PaypalPaymentAdapter implements PaymentProcessorInterface
{
    private PaypalPaymentProcessor $paymentProcessor;

    public function  __construct(
        PaypalPaymentProcessor $paymentProcessor
    ) {
        $this->paymentProcessor = $paymentProcessor;
    }

    /**
     * @throws PaymentFailedException
     */
    public function pay(Money $money): void
    {
        $amount = $money->getAmount();

        try {
            $this->paymentProcessor->pay($amount);
        } catch (\Exception $exception) {
            throw new PaymentFailedException($exception->getMessage());
        }
    }
}

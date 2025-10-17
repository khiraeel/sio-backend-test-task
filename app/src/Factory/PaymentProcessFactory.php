<?php

namespace App\Factory;

use App\Enum\PaymentProcessorType;
use App\Interface\PaymentProcessorInterface;
use App\Service\Payment\PaypalPaymentAdapter;
use App\Service\Payment\StripePaymentAdapter;
use Systemeio\TestForCandidates\PaymentProcessor\PaypalPaymentProcessor;
use Systemeio\TestForCandidates\PaymentProcessor\StripePaymentProcessor;

class PaymentProcessFactory
{
    public function create(PaymentProcessorType $type): PaymentProcessorInterface
    {
        return match ($type) {
            PaymentProcessorType::PAYPAL => new PaypalPaymentAdapter(new PaypalPaymentProcessor()),
            PaymentProcessorType::STRIPE => new StripePaymentAdapter(new StripePaymentProcessor()),
        };
    }
}

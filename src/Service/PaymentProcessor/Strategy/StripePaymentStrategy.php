<?php

namespace App\Service\PaymentProcessor\Strategy;

use App\Service\PaymentProcessor\Enum\PaymentStrategy;
use App\Service\PaymentProcessor\Exception\PaymentException;
use StripePaymentProcessor;

class StripePaymentStrategy extends AbstractPaymentStrategy
{
    public function __construct(
        private readonly StripePaymentProcessor $processor
    ) {}

    /** @inheritDoc */
    public function processPayment(int $price): void
    {
        // TODO: Check negative price?
        $priceInEuro = (int)round($this->centsToEuro($price));

        if (false === $this->processor->processPayment($priceInEuro)) {
            throw new PaymentException();
        }
    }

    public function getName(): PaymentStrategy
    {
        return PaymentStrategy::Stripe;
    }
}

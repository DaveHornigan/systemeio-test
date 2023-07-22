<?php

namespace App\Service\PaymentProcessor\Strategy;

use App\Service\PaymentProcessor\Enum\PaymentStrategy;
use App\Service\PaymentProcessor\Exception\PaymentException;
use Exception;
use PaypalPaymentProcessor;

class PaypalPaymentStrategy extends AbstractPaymentStrategy
{
    public function __construct(
        private readonly PaypalPaymentProcessor $processor
    ) {}

    /** @inheritDoc */
    public function processPayment(int $price): void
    {
        // TODO: Check negative price?
        $priceInEuro = (int)round($this->centsToEuro($price));

        try {
            $this->processor->pay($priceInEuro);
        } catch (Exception $e) {
            throw new PaymentException(previous: $e);
        }
    }

    public function getName(): PaymentStrategy
    {
        return PaymentStrategy::PayPal;
    }
}

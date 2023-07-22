<?php

namespace App\Service\PaymentProcessor;

use App\Service\PaymentProcessor\Enum\PaymentStrategy;
use App\Service\PaymentProcessor\Exception\PaymentException;

class PaymentProcessor implements PaymentProcessorInterface
{
    public function __construct(private readonly PaymentStrategyRegistry $registry) { }

    /** @inheritDoc */
    public function processPayment(int $price, PaymentStrategy $strategyName): void
    {
        try {
            $this->registry->getStrategy($strategyName)->processPayment($price);
        } catch (\Exception $e) {
            throw new PaymentException(previous: $e);
        }
    }
}

<?php

namespace App\Service\PaymentProcessor;

use App\Service\PaymentProcessor\Enum\PaymentStrategy;
use App\Service\PaymentProcessor\Exception\PaymentException;

interface PaymentProcessorInterface
{
    /** @throws PaymentException if payment fail */
    public function processPayment(int $price, PaymentStrategy $strategyName): void;
}

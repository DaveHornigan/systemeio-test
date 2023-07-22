<?php

namespace App\Service\PaymentProcessor\Strategy;

use App\Service\PaymentProcessor\Enum\PaymentStrategy;
use App\Service\PaymentProcessor\Exception\PaymentException;

abstract class AbstractPaymentStrategy
{
    protected function centsToEuro(int $euroCents): float
    {
        return $euroCents / 100;
    }

    /** @throws PaymentException if payment fail */
    abstract public function processPayment(int $price): void;
    abstract public function getName(): PaymentStrategy;
}

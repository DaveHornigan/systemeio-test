<?php

namespace App\Service\PaymentProcessor;

use App\Service\PaymentProcessor\Enum\PaymentStrategy;
use App\Service\PaymentProcessor\Exception\NotFoundException;
use App\Service\PaymentProcessor\Strategy\AbstractPaymentStrategy;

class PaymentStrategyRegistry
{
    /** @var array<string, AbstractPaymentStrategy> */
    private array $strategies = [];

    public function register(AbstractPaymentStrategy $strategy): void
    {
        $this->strategies[$strategy->getName()->name] = $strategy;
    }

    public function hasStrategy(PaymentStrategy $strategyName): bool
    {
        return array_key_exists($strategyName->name, $this->strategies);
    }

    /** @throws NotFoundException */
    public function getStrategy(PaymentStrategy $strategyName): AbstractPaymentStrategy
    {
        if ($this->hasStrategy($strategyName)) {
            return $this->strategies[$strategyName->name];
        }

        throw new NotFoundException("$strategyName->name payment strategy not found.");
    }
}

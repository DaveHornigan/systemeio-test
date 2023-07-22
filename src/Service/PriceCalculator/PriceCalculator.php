<?php

namespace App\Service\PriceCalculator;

class PriceCalculator implements PriceCalculatorInterface
{
    public function calculate(int $price, int $taxPercent): int
    {
        return $price + ($price / 100 * $taxPercent);
    }
}

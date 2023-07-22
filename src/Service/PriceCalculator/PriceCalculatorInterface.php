<?php

namespace App\Service\PriceCalculator;

interface PriceCalculatorInterface
{
    public function calculate(int $price, int $taxPercent): int;
}

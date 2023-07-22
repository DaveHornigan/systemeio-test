<?php

namespace App\Service\PriceCalculator;

interface PriceCalculatorInterface
{
    public function calculate(int $price, int $tax, int $discount = 0): int;
}

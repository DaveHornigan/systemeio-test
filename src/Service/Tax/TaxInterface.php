<?php

namespace App\Service\Tax;

interface TaxInterface
{
    public function getTaxPercentByNumber(string $taxNumber): int;
}

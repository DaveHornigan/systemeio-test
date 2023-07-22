<?php

namespace App\Service\Tax;

use App\Service\Tax\Exception\NotFoundException;

interface TaxInterface
{
    /** @throws NotFoundException */
    public function getTaxPercentByNumber(string $taxNumber): int;
    /** @throws NotFoundException */
    public function getPriceWithTaxByNumber(int $price, string $taxNumber): int;
}

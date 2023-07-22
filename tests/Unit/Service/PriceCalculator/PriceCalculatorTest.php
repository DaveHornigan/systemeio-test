<?php

namespace App\Tests\Unit\Service\PriceCalculator;

use App\Service\PriceCalculator\PriceCalculator;
use PHPUnit\Framework\TestCase;

class PriceCalculatorTest extends TestCase
{
    /** @dataProvider getVariants */
    public function testCalculate(int $price, int $taxPercent, int $expectedPrice): void
    {
        $service = new PriceCalculator();

        self::assertSame($expectedPrice, $service->calculate($price, $taxPercent));
    }

    public function getVariants(): array
    {
        return [
            ['price' => 100, 'taxPercent' => 19, 'expectedPrice' => 119],
            ['price' => 100, 'taxPercent' => 40, 'expectedPrice' => 140],
            ['price' => 100, 'taxPercent' => 85, 'expectedPrice' => 185],
            ['price' => 12345, 'taxPercent' => 50, 'expectedPrice' => 18517],
        ];
    }
}

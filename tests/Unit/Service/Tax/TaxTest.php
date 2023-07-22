<?php

namespace App\Tests\Unit\Service\Tax;

use App\Entity;
use App\Service\Tax\Exception\NotFoundException;
use App\Service\Tax\Tax;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectRepository;
use PHPUnit\Framework\TestCase;

class TaxTest extends TestCase
{
    /** @dataProvider getValidTaxNumbers */
    public function testGetTaxPercentByNumber(string $taxNumber, int $expectedPercent): void
    {
        $em = $this->createMock(EntityManagerInterface::class);
        $repo = $this->createMock(ObjectRepository::class);
        $em->method('getRepository')->willReturn($repo);
        $repo->method('findOneBy')->willReturnCallback(static function () {
            $countryCode = func_get_arg(0)['countryCode'];
            $taxPercent = match ($countryCode) {
                'DE' => 19,
                'IT' => 22,
                'FR' => 20,
                'GR' => 24
            };
            return new Entity\Tax('Stubbed name', $countryCode, $taxPercent);
        });

        $service = new Tax($em);

        self::assertSame($expectedPercent, $service->getTaxPercentByNumber($taxNumber));
    }

    public function getValidTaxNumbers(): array {
        return [
            ['taxNumber' => 'DE123456789', 'expectedPercent' => 19],
            ['taxNumber' => 'IT12345678901', 'expectedPercent' => 22],
            ['taxNumber' => 'GR123456789', 'expectedPercent' => 24],
            ['taxNumber' => 'FRHH123456789', 'expectedPercent' => 20],
        ];
    }

    public function testGetTaxPercentByNumberInvalidCode(): void
    {
        $em = $this->createMock(EntityManagerInterface::class);
        $repo = $this->createMock(ObjectRepository::class);
        $em->method('getRepository')->willReturn($repo);
        $repo->method('findOneBy')->willReturn(null);

        $service = new Tax($em);

        $this->expectException(NotFoundException::class);
        $service->getTaxPercentByNumber('BR123456789');
    }

    /** @dataProvider getPriceAndTaxVariants */
    public function testGetPriceWithTaxByNumber(int $price, int $taxPercent, int $expectedPrice): void
    {
        $em = $this->createMock(EntityManagerInterface::class);
        $repo = $this->createMock(ObjectRepository::class);
        $em->method('getRepository')->willReturn($repo);
        $repo->method('findOneBy')->willReturn(
            new Entity\Tax('country name', 'DE', $taxPercent)
        );

        $service = new Tax($em);

        self::assertSame($expectedPrice, $service->getPriceWithTaxByNumber($price, 'stub'));
    }

    public function getPriceAndTaxVariants(): array
    {
        return [
            ['price' => 100, 'taxPercent' => 19, 'expectedPrice' => 119],
            ['price' => 100, 'taxPercent' => 40, 'expectedPrice' => 140],
            ['price' => 100, 'taxPercent' => 85, 'expectedPrice' => 185],
            ['price' => 12345, 'taxPercent' => 50, 'expectedPrice' => 18517],
        ];
    }
}
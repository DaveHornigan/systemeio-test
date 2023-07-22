<?php

namespace App\Tests\Integration\Controller;

use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;

class ProductControllerTest extends WebTestCase
{
    public const CALCULATE_COST_API_URI = '/api/product/calculate-cost';
    private KernelBrowser $browser;

    public function calculateCostValidRequestDataProvider(): iterable {
        yield ['requestBody' => json_encode([
            'product' => '1',
            'taxNumber' => 'DE123456789',
            'couponCode' => 'D15',
            'paymentProcessor' => 'paypal'
        ], JSON_THROW_ON_ERROR)];
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->browser = self::createClient();
    }

    /** @dataProvider calculateCostValidRequestDataProvider */
    public function testCalculateCost(string $requestBody): void
    {
        $this->browser->request(Request::METHOD_POST, self::CALCULATE_COST_API_URI, content: $requestBody);
        self::assertResponseIsSuccessful();
        self::assertResponseFormatSame('json');
    }

    public function testCalculateCostValidationError(): void
    {
        $requestBody = json_encode([
            'product' => null,
            'taxNumber' => 'DX123456789',
            'couponCode' => 'D15',
            'paymentProcessor' => 'invalid'
        ], JSON_THROW_ON_ERROR);

        $this->browser->request(Request::METHOD_POST, self::CALCULATE_COST_API_URI, content: $requestBody);
        self::assertResponseIsUnprocessable();
        self::assertResponseFormatSame('json');
    }
}
<?php

namespace App\Tests\Functional\Controller;

use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Component\HttpFoundation\Request;

class ProductControllerTest extends \Symfony\Bundle\FrameworkBundle\Test\WebTestCase
{
    private KernelBrowser $browser;

    public function calculateCostRequestDataProvider(): iterable {
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

    /** @dataProvider calculateCostRequestDataProvider */
    public function testCalculateCost(string $requestBody): void
    {
        $this->browser->request(Request::METHOD_POST, '/api/product/calculate-cost', content: $requestBody);
        self::assertResponseIsSuccessful();
    }
}
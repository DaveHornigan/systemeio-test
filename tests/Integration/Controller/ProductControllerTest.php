<?php

namespace App\Tests\Integration\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Nelmio\Alice\Loader\NativeLoader;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;

class ProductControllerTest extends WebTestCase
{
    public const CALCULATE_COST_API_URI = '/api/product/calculate-cost';
    private KernelBrowser $browser;

    public function calculateCostValidRequestDataProvider(): iterable {
        yield ['requestBody' => [
            'product' => '1',
            'taxNumber' => 'DE123456789',
            'couponCode' => 'D15',
            'paymentProcessor' => 'paypal'
        ]];
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->browser = self::createClient();
    }

    /** @dataProvider calculateCostValidRequestDataProvider */
    public function testCalculateCost(array $requestBody): void
    {
        $loader = new NativeLoader();
        $objects = $loader->loadFiles([
            dirname(__DIR__, 3) . '/fixtures/coupon.yaml',
            dirname(__DIR__, 3) . '/fixtures/tax.yaml',
            dirname(__DIR__, 3) . '/fixtures/product.yaml',
        ])->getObjects();
        foreach ($objects as $object) {
            self::getContainer()->get(EntityManagerInterface::class)->persist($object);
        }
        self::getContainer()->get(EntityManagerInterface::class)->flush();

        $requestBody['couponCode'] = $objects['coupon_active']->getCode();

        $this->browser->request(Request::METHOD_POST, self::CALCULATE_COST_API_URI, content: json_encode($requestBody));
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
<?php

namespace App\Tests\Functional\Service\PaymentProcessor;

use App\Service\PaymentProcessor\Enum\PaymentStrategy;
use App\Service\PaymentProcessor\Exception\PaymentException;
use App\Service\PaymentProcessor\PaymentProcessorInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class PaymentProcessorTest extends KernelTestCase
{
    private PaymentProcessorInterface $service;

    public function paymentValidVariants(): array
    {
        return [
            ['price' => 100, 'strategy' => PaymentStrategy::PayPal],
            ['price' => 1000, 'strategy' => PaymentStrategy::PayPal],
            ['price' => 10000, 'strategy' => PaymentStrategy::PayPal],
            ['price' => 1000, 'strategy' => PaymentStrategy::Stripe],
            ['price' => 10000, 'strategy' => PaymentStrategy::Stripe],
        ];
    }

    public function paymentInvalidVariants(): array
    {
        return [
            ['price' => 10100, 'strategy' => PaymentStrategy::PayPal],
            ['price' => 900, 'strategy' => PaymentStrategy::Stripe],
        ];
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->service = self::getContainer()->get(PaymentProcessorInterface::class);
    }

    /** @dataProvider paymentValidVariants */
    public function testProcessPayment(int $price, PaymentStrategy $strategy): void
    {
        $this->expectNotToPerformAssertions();
        $this->service->processPayment($price, $strategy);
    }

    /** @dataProvider paymentInvalidVariants */
    public function testProcessPaymentError(int $price, PaymentStrategy $strategy): void
    {
        $this->expectException(PaymentException::class);
        $this->service->processPayment($price, $strategy);
    }
}
<?php

namespace App\Tests\Unit\Service\Discount;

use App\Entity;
use App\Service\Discount\Discount;
use App\Service\Discount\Enum\CouponType;
use App\Service\Discount\Exception\CouponNotValidException;
use App\Service\Discount\Exception\NotFoundException;
use DateTime;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectRepository;
use PHPUnit\Framework\TestCase;

class DiscountTest extends TestCase
{
    /** @dataProvider getValidCoupons */
    public function testGetCoupon(Entity\Coupon $coupon, CouponType $expectedType, int $expectedValue): void
    {
        $em = $this->createMock(EntityManagerInterface::class);
        $repo = $this->createMock(ObjectRepository::class);
        $em->method('getRepository')->willReturn($repo);
        $repo->method('findOneBy')->willReturn($coupon);

        $service = new Discount($em);

        $coupon = $service->getCoupon('D123');
        self::assertSame($expectedType, $coupon->type);
        self::assertSame($expectedValue, $coupon->value);
    }

    public function getValidCoupons(): array
    {
        return [
            [
                'coupon' => new Entity\Coupon('D123', Entity\Enum\CouponType::Fixed, 1000, new DateTime('+5 days')),
                'expectedType' => CouponType::Fixed,
                'expectedValue' => 1000
            ],
            [
                'coupon' => new Entity\Coupon('D123', Entity\Enum\CouponType::Percent, 10, new DateTime('+5 days')),
                'expectedType' => CouponType::Percent,
                'expectedValue' => 10
            ],
        ];
    }

    /** @dataProvider getNotValidCoupons */
    public function testGetCouponException(?Entity\Coupon $coupon, string $expectedException): void
    {
        $em = $this->createMock(EntityManagerInterface::class);
        $repo = $this->createMock(ObjectRepository::class);
        $em->method('getRepository')->willReturn($repo);
        $repo->method('findOneBy')->willReturn($coupon);

        $service = new Discount($em);

        $this->expectException($expectedException);
        $service->getCoupon('D123');
    }

    public function getNotValidCoupons(): array
    {
        return [
            [
                'coupon' => new Entity\Coupon('D123', Entity\Enum\CouponType::Fixed, 1000, new DateTime('-5 days')),
                'expectedException' => CouponNotValidException::class
            ],
            [
                'coupon' => new Entity\Coupon('D123', Entity\Enum\CouponType::Percent, 5, new DateTime('+5 days'), new DateTimeImmutable('-1 day')),
                'expectedException' => CouponNotValidException::class
            ],
            [
                'coupon' => null,
                'expectedException' => NotFoundException::class
            ],
        ];
    }
}
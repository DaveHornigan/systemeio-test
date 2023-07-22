<?php

namespace App\Service\Discount;

use App\Service\Discount\Enum\CouponType;
use App\Service\Discount\Exception\CouponNotValidException;
use App\Service\Discount\Exception\NotFoundException;
use App\Service\Discount\ValueObject\Coupon;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectRepository;

class Discount implements DiscountInterface
{
    private readonly ObjectRepository $repository;

    public function __construct(
        EntityManagerInterface $entityManager
    ) {
        $this->repository = $entityManager->getRepository(\App\Entity\Coupon::class);
    }

    /** @inheritDoc */
    public function getCoupon(string $couponCode): Coupon
    {
        if (null !== $coupon = $this->repository->findOneBy(['code' => $couponCode])) {
            if ($coupon->getExpiredAt() > new DateTimeImmutable()) {
                if ($coupon->getUsedAt() === null) {
                    return new Coupon(
                        CouponType::from($coupon->getType()->value),
                        $coupon->getValue()
                    );
                }

                throw new CouponNotValidException('Coupon already used.');
            }

            throw new CouponNotValidException('Coupon expired.');
        }

        throw new NotFoundException('Coupon not found.');
    }
}

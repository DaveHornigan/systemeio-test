<?php

namespace App\Service\Discount;

use App\Service\Discount\Exception\CouponNotValidException;
use App\Service\Discount\Exception\NotFoundException;
use App\Service\Discount\ValueObject\Coupon;

interface DiscountInterface
{
    /** @throws NotFoundException|CouponNotValidException */
    public function getCoupon(string $couponCode): Coupon;
}

<?php

namespace App\Service\Discount;

use App\Service\Discount\ValueObject\Coupon;

interface DiscountInterface
{
    public function getCoupon(string $couponCode): Coupon;
}

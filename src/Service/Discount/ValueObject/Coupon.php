<?php

namespace App\Service\Discount\ValueObject;

use App\Service\Discount\Enum\CouponType;

class Coupon
{
    public function __construct(
        public readonly CouponType $type,
        public readonly int $value
    ) {}

    public function getFixedPrice(int $price): int
    {
        if ($this->type === CouponType::Fixed) {
            return $this->value;
        }

        // round to 1 cent
        return (int)($price / 100 * $this->value);
    }
}

<?php

namespace App\Service\Discount\Enum;

enum CouponType: string
{
    case Fixed = 'FIXED';
    case Percent = 'PERCENT';
}

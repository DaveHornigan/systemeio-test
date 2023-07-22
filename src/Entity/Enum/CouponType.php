<?php

namespace App\Entity\Enum;

enum CouponType: string
{
    case Fixed = 'FIXED';
    case Percent = 'PERCENT';
}

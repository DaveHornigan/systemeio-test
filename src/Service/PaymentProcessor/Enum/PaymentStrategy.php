<?php

namespace App\Service\PaymentProcessor\Enum;

enum PaymentStrategy
{
    case PayPal;
    case Stripe;
}

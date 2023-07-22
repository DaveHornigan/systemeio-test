<?php

namespace App\Service\PaymentProcessor\Enum;

enum PaymentStrategy: string
{
    case PayPal = 'paypal';
    case Stripe = 'stripe';
}

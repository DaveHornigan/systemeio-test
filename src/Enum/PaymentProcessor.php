<?php

namespace App\Enum;

enum PaymentProcessor: string
{
    case PayPal = 'paypal';
    case Stripe = 'stripe';
}

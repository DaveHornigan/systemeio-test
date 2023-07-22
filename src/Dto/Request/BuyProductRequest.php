<?php

namespace App\Dto\Request;

use App\Enum\PaymentProcessor;
use Symfony\Component\Validator\Constraints as Assert;

class BuyProductRequest extends CalculateProductCostRequest
{
    #[Assert\NotBlank]
    public PaymentProcessor $paymentProcessor;
}

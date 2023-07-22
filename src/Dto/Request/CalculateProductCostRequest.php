<?php

namespace App\Dto\Request;

use App\Enum\PaymentProcessor;
use Symfony\Component\Validator\Constraints as Assert;

class CalculateProductCostRequest
{
    #[Assert\NotBlank]
    #[Assert\Type('string')]
    public mixed $product; // why is it in the request body?
    #[Assert\NotBlank]
    #[Assert\Type('string')]
    #[Assert\Regex('/((DE|GR)[0-9]{9}|IT[0-9]{11}|FR[A-Z]{2}[0-9]{9})/', 'Invalid tax number format')]
    public mixed $taxNumber;
    #[Assert\Type('string')]
    public mixed $couponCode = null;
    public PaymentProcessor $paymentProcessor; // Not required for cost calculation... Why this is in the body of the request is not clear.
}

<?php

namespace App\Dto\Response;

class PaymentCostResponse
{
    public function __construct(
        public readonly int $cost
    ) {}
}

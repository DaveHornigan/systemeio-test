<?php

namespace App\Service\Product\ValueObject;

class Product
{
    public function __construct(
        public readonly string $productId,
        public readonly string $productName,
        public readonly int $price
    ) {}
}

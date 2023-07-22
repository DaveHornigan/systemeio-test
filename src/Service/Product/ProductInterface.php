<?php

namespace App\Service\Product;

use App\Service\Product\ValueObject\Product;

interface ProductInterface
{
    public function getProduct(string $productId): Product;
}

<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/product', 'product.')]
class ProductController
{
    #[Route(name: 'calculate-cost', methods: [Request::METHOD_POST])]
    public function calculateCost(Request $request): JsonResponse
    {
        return new JsonResponse([]);
    }
}

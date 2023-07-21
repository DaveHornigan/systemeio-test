<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/product', 'product.')]
class ProductController
{
    #[Route('/calculate-cost', name: 'calculate-cost', methods: [Request::METHOD_POST])]
    public function calculateCost(Request $request): Response
    {
        return new Response(null, Response::HTTP_OK);
    }
}

<?php

namespace App\Tests\Unit\Service\Product;

use App\Entity;
use App\Service\Product\Product;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectRepository;
use PHPUnit\Framework\TestCase;

class ProductTest extends TestCase
{
    public function testGetProduct(): void
    {
        $em = $this->createMock(EntityManagerInterface::class);
        $repo = $this->createMock(ObjectRepository::class);
        $em->method('getRepository')->willReturn($repo);

        $productEntity = new Entity\Product(
            'Fake Product',
            1000,
            id: 'fakeId'
        );

        $repo->method('find')->willReturnCallback(fn() => $productEntity);

        $service = new Product($em);

        $product = $service->getProduct('fakeId');
        self::assertSame($productEntity->getId(), $product->productId);
        self::assertSame($productEntity->getName(), $product->productName);
        self::assertSame($productEntity->getPrice(), $product->price);
    }
}
<?php

namespace App\Entity;

use DateTimeInterface;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class Product
{
    public function __construct(
        #[ORM\Id]
        #[ORM\GeneratedValue(strategy: 'UUID')]
        #[ORM\Column(type: Types::GUID)]
        private string $id,
        #[ORM\Column(type: Types::STRING, length: 200)]
        private string $name,
        #[ORM\Column(type: Types::INTEGER)]
        private int $price,
        #[ORM\Column(type: Types::DATETIME_IMMUTABLE)]
        private DateTimeInterface $createdAt,
        #[ORM\Column(type: Types::DATETIME_MUTABLE)]
        private DateTimeInterface $updatedAt,
    ) {}

    public function getId(): string
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getPrice(): int
    {
        return $this->price;
    }

    public function getCreatedAt(): DateTimeInterface
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): DateTimeInterface
    {
        return $this->updatedAt;
    }
}

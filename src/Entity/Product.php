<?php

namespace App\Entity;

use DateTime;
use DateTimeImmutable;
use DateTimeInterface;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\IdGenerator\UuidGenerator;

#[ORM\Entity]
class Product
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\Column(type: Types::GUID)]
    #[ORM\CustomIdGenerator(class: UuidGenerator::class)]
    private ?string $id = null;

    public function __construct(
        #[ORM\Column(type: Types::STRING, length: 200)]
        private string $name,
        #[ORM\Column(type: Types::INTEGER)]
        private int $price,
        #[ORM\Column(type: Types::DATETIME_IMMUTABLE)]
        private DateTimeInterface $createdAt = new DateTimeImmutable(),
        #[ORM\Column(type: Types::DATETIME_MUTABLE)]
        private DateTimeInterface $updatedAt = new DateTime(),
        ?string $id = null
    ) {
        $this->id = $id;
    }

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

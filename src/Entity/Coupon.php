<?php

namespace App\Entity;

use App\Entity\Enum\CouponType;
use DateTimeImmutable;
use DateTimeInterface;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\IdGenerator\UuidGenerator;

#[ORM\Entity]
class Coupon
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\Column(type: Types::GUID)]
    #[ORM\CustomIdGenerator(class: UuidGenerator::class)]
    private ?string $id = null;

    public function __construct(
        #[ORM\Column(type: Types::STRING, length: 32)]
        private string $code,
        #[ORM\Column(type: Types::STRING, length: 16, enumType: CouponType::class)]
        private CouponType $type,
        #[ORM\Column(type: Types::SMALLINT)]
        private int $value,
        #[ORM\Column(type: Types::DATETIME_MUTABLE)]
        private DateTimeInterface $expiredAt,
        #[ORM\Column(type: Types::DATETIME_IMMUTABLE, nullable: true)]
        private ?DateTimeInterface $usedAt = null,
        #[ORM\Column(type: Types::DATETIME_IMMUTABLE)]
        private DateTimeInterface $createdAt = new DateTimeImmutable(),
    ) {}

    public function getId(): string
    {
        return $this->id;
    }

    public function getCode(): string
    {
        return $this->code;
    }

    public function getType(): CouponType
    {
        return $this->type;
    }

    public function getValue(): int
    {
        return $this->value;
    }

    public function getExpiredAt(): DateTimeInterface
    {
        return $this->expiredAt;
    }

    public function getUsedAt(): ?DateTimeInterface
    {
        return $this->usedAt;
    }

    public function getCreatedAt(): DateTimeInterface
    {
        return $this->createdAt;
    }
}

<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class Tax
{
    public function __construct(
        #[ORM\Id]
        #[ORM\GeneratedValue(strategy: 'UUID')]
        #[ORM\Column(type: Types::GUID)]
        private string $id,
        #[ORM\Column(type: Types::STRING, length: 32)]
        private string $countryName,
        #[ORM\Column(type: Types::STRING, length: 3)]
        private string $countryCode,
        #[ORM\Column(name: 'tax_percent', type: Types::SMALLINT)]
        private int $percent,
    ) {}

    public function getId(): string
    {
        return $this->id;
    }

    public function getCountryName(): string
    {
        return $this->countryName;
    }

    public function getCountryCode(): int
    {
        return $this->countryCode;
    }

    public function getPercent(): int
    {
        return $this->percent;
    }
}

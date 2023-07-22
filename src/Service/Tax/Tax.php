<?php

namespace App\Service\Tax;

use App\Service\Tax\Exception\NotFoundException;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectRepository;

class Tax implements TaxInterface
{
    private ObjectRepository $repository;

    public function __construct(
        EntityManagerInterface $entityManager
    ) {
        $this->repository = $entityManager->getRepository(\App\Entity\Tax::class);
    }

    /** @inheritDoc */
    public function getTaxPercentByNumber(string $taxNumber): int
    {
        $countryCode = mb_str_split($taxNumber, 2)[0];
        if (null !== $tax = $this->repository->findOneBy(['countryCode' => $countryCode])) {
            return $tax->getPercent();
        }

        throw new NotFoundException('Tax not found.');
    }

    /** @inheritDoc */
    public function getPriceWithTaxByNumber(int $price, string $taxNumber): int
    {
        $taxPercent = $this->getTaxPercentByNumber($taxNumber);

        return $price + ($price / 100 * $taxPercent);
    }
}

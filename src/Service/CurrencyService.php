<?php

declare(strict_types=1);

namespace App\Service;

use App\DTO\CurrencyValueDTO;
use App\DTO\SubtractionRateDTO;
use App\Entity\CurrencyRate;
use App\Repository\CurrencyRateRepository;
use Doctrine\ORM\EntityManagerInterface;

class CurrencyService
{
    private CurrencyRateRepository $repository;

    public function __construct(EntityManagerInterface $em)
    {
        $this->repository = $em->getRepository(CurrencyRate::class);
    }

    /**
     * @param CurrencyValueDTO $valueDTO
     */
    public function save(CurrencyValueDTO $valueDTO): void
    {
        $currencyRate = new CurrencyRate();
        $currencyRate
            ->setBankName($valueDTO->getBank())
            ->setCurrency($valueDTO->getCurrency())
            ->setCurrencyBase($valueDTO->getBaseCurrency())
            ->setRateBuy($valueDTO->getRateToBuy())
            ->setRateSell($valueDTO->getRateToSell());

        $this->repository->save($currencyRate);
    }

    /**
     * @param CurrencyValueDTO $valueDTO
     *
     * @return SubtractionRateDTO|null
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function getDifferenceBetweenRates(CurrencyValueDTO $valueDTO): ?SubtractionRateDTO
    {
        $previousRate = $this->repository->findLastOne(
            $valueDTO->getBank(),
            $valueDTO->getCurrency(),
            $valueDTO->getBaseCurrency()
        );

        if (is_null($previousRate)) {
            return null;
        }

        return new SubtractionRateDTO(
            $this->calculateRateChange(floatval($valueDTO->getRateToBuy()),  floatval($previousRate->getRateBuy())),
            $this->calculateRateChange(floatval($valueDTO->getRateToSell()),  floatval($previousRate->getRateSell())),
        );
    }

    private function calculateRateChange(float $newValue, float $oldValue): float
    {
        return round((abs(($newValue - $oldValue) / $oldValue) * 100), 5);
    }
}

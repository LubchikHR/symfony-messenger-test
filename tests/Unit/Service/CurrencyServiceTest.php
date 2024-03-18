<?php

declare(strict_types=1);

namespace App\Tests\Unit\Service;

use App\DTO\CurrencyValueDTO;
use App\DTO\SubtractionRateDTO;
use App\Entity\CurrencyRate;
use App\Repository\CurrencyRateRepository;
use App\Service\CurrencyService;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\TestCase;

class CurrencyServiceTest extends TestCase
{
    private EntityManagerInterface $entityManager;
    private CurrencyRateRepository $repository;

    protected function setUp(): void
    {
        $this->entityManager = $this->createMock(EntityManagerInterface::class);
        $this->repository = $this->createMock(CurrencyRateRepository::class);
    }

    public function testGetDifferenceBetweenRates(): void
    {
        $previousRate = new CurrencyRate();
        $previousRate
            ->setBankName('Bank')
            ->setCurrency('EUR')
            ->setCurrencyBase('USD')
            ->setRateBuy('1.20')
            ->setRateSell('1.40');

        $this->repository->expects($this->once())
            ->method('findLastOne')
            ->with('Bank', 'EUR', 'USD')
            ->willReturn($previousRate);

        $this->entityManager->method('getRepository')
            ->willReturn($this->repository);

        $currencyValueDTO = new CurrencyValueDTO('Bank', 'EUR', 'USD', '1.23', '1.47');

        $currencyService = new CurrencyService($this->entityManager);
        $subtractionRateDTO = $currencyService->getDifferenceBetweenRates($currencyValueDTO);

        $this->assertInstanceOf(SubtractionRateDTO::class, $subtractionRateDTO);
        $this->assertEquals(2.5, $subtractionRateDTO->getBuyDifference()); //percent
        $this->assertEquals(5.0, $subtractionRateDTO->getSellDifference()); //percent
    }
}

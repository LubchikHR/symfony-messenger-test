<?php

declare(strict_types=1);

namespace App\DTO;

class CurrencyValueDTO
{
    private string $bank;
    private string $currency;
    private string $baseCurrency;
    private string $rateToSell;
    private string $rateToBuy;

    public function __construct(
        string $bank,
        string $currency,
        string $baseCurrency,
        string $rateToBuy,
        string $rateToSell
    ) {
        $this->bank = $bank;
        $this->currency = $currency;
        $this->baseCurrency = $baseCurrency;
        $this->rateToBuy = $rateToBuy;
        $this->rateToSell = $rateToSell;
    }

    public function getBank(): string
    {
        return $this->bank;
    }

    public function getCurrency(): string
    {
        return $this->currency;
    }

    public function getBaseCurrency(): string
    {
        return $this->baseCurrency;
    }

    public function getRateToSell(): string
    {
        return $this->rateToSell;
    }

    public function getRateToBuy(): string
    {
        return $this->rateToBuy;
    }
}

<?php

declare(strict_types=1);

namespace App\DTO;

class SubtractionRateDTO
{
    private float $subtractionValueBuy;
    private float $subtractionValueSell;

    public function __construct(float $subtractionValueBuy, float $subtractionValueSell)
    {
        $this->subtractionValueBuy = $subtractionValueBuy;
        $this->subtractionValueSell = $subtractionValueSell;
    }

    public function getBuyDifference(): float
    {
        return $this->subtractionValueBuy;
    }

    public function getSellDifference(): float
    {
        return $this->subtractionValueSell;
    }
}

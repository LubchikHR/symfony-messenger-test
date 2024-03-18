<?php

declare(strict_types=1);

namespace App\Gateway;

use App\DTO\CurrencyValueDTO;

interface BankProviderInterface
{
    /**
     * @return CurrencyValueDTO[]
     */
    public function getExchange(): array;
}

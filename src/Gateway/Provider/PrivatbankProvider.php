<?php

declare(strict_types=1);

namespace App\Gateway\Provider;

use App\DTO\CurrencyValueDTO;
use App\Gateway\AbstractBankProvider;
use App\Gateway\BankProviderInterface;
use App\Gateway\Exception\ProviderResponseException;

class PrivatbankProvider extends AbstractBankProvider implements BankProviderInterface
{
    public const BANK = 'PRIVATBANK';

    /**
     * {@inheritDoc}
     * @throws ProviderResponseException
     */
    public function getExchange(): array
    {
        $result = [];
        $apiResponse = $this->request();

        if (!is_null($apiResponse)) {
            foreach ($apiResponse as $currency) {
                $result[$currency['ccy']] = new CurrencyValueDTO(
                    self::BANK,
                    $currency['ccy'],
                    $currency['base_ccy'],
                    $currency['buy'],
                    $currency['sale'],
                );
            }

            return $result;
        }

        throw ProviderResponseException::exception(static::class);
    }
}

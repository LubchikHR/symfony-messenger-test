<?php

declare(strict_types=1);

namespace App\Gateway\Provider;

use App\DTO\CurrencyValueDTO;
use App\Gateway\AbstractBankProvider;
use App\Gateway\BankProviderInterface;
use App\Gateway\Exception\ProviderResponseException;

class MonobankProvider extends AbstractBankProvider implements BankProviderInterface
{
    private const UAH = 'UAH';
    private const USD = 'USD';
    private const EUR = 'EUR';

    private const SUPPORTED_CURRENCIES = [
        840 => self::USD,
        978 => self::EUR,
        980 => self::UAH,
    ];

    public const BANK = 'MONOBANK';

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
                if (isset(self::SUPPORTED_CURRENCIES[$currency['currencyCodeA']])) {
                    $result[] = new CurrencyValueDTO(
                        self::BANK,
                        self::SUPPORTED_CURRENCIES[$currency['currencyCodeA']],
                        self::SUPPORTED_CURRENCIES[$currency['currencyCodeB']],
                        (string) $currency['rateBuy'],
                        (string) $currency['rateSell'],
                    );
                }
            }

            return $result;
        }

        throw ProviderResponseException::exception(static::class);
    }
}

<?php

declare(strict_types=1);

namespace App\Tests\Gateway\Provider;

use App\DTO\CurrencyValueDTO;
use App\Gateway\Exception\ProviderResponseException;
use App\Gateway\Provider\MonobankProvider;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;

class MonobankProviderTest extends TestCase
{
    public function testGetExchange(): void
    {
        $mockResponse = [
            ['currencyCodeA' => 840, 'rateBuy' => 27.5, 'rateSell' => 28.1], // USD
            ['currencyCodeA' => 978, 'rateBuy' => 32.2, 'rateSell' => 33.3], // EUR
        ];

        $responseMock = $this->createMock(ResponseInterface::class);
        $responseMock->method('toArray')->willReturn($mockResponse);
        $responseMock->method('getStatusCode')->willReturn(200);
        $responseMock->method('getHeaders')->willReturn([true]);

        $client = $this->createMock(HttpClientInterface::class);
        $client->method('request')->willReturn($responseMock);

        $logger = $this->createMock(LoggerInterface::class);

        $provider = new MonobankProvider($client, $logger);
        $provider->setUrl('');

        $expectedResult = [
            'USD' => new CurrencyValueDTO('MONOBANK', 'USD', 'UAH', '27.5', '28.1'),
            'EUR' => new CurrencyValueDTO('MONOBANK', 'EUR', 'UAH', '32.2', '33.3'),
        ];

        $this->assertEquals($expectedResult, $provider->getExchange());
    }

    public function testGetExchangeThrowsException(): void
    {
        $responseMock = $this->createMock(ResponseInterface::class);

        $client = $this->createMock(HttpClientInterface::class);
        $client->method('request')->willReturn($responseMock);

        $logger = $this->createMock(LoggerInterface::class);

        $provider = new MonobankProvider($client, $logger);
        $provider->setUrl('');

        $this->expectException(ProviderResponseException::class);
        $provider->getExchange();
    }
}

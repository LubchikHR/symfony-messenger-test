<?php

declare(strict_types=1);

namespace App\Tests\Unit\Provider;

use App\DTO\CurrencyValueDTO;
use App\Gateway\Exception\ProviderResponseException;
use App\Gateway\Provider\PrivatbankProvider;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;

class PrivatbankProviderTest extends TestCase
{
    public function testGetExchange(): void
    {
        $mockResponse = [
            ['ccy' => 'USD', 'base_ccy' => 'UAH', 'buy' => '27.5', 'sale' => '28.1'],
            ['ccy' => 'EUR', 'base_ccy' => 'UAH', 'buy' => '32.2', 'sale' => '33.3'],
        ];

        $responseMock = $this->createMock(ResponseInterface::class);
        $responseMock->method('toArray')->willReturn($mockResponse);
        $responseMock->method('getStatusCode')->willReturn(200);
        $responseMock->method('getHeaders')->willReturn([true]);

        $client = $this->createMock(HttpClientInterface::class);
        $client->method('request')->willReturn($responseMock);

        $logger = $this->createMock(LoggerInterface::class);

        $provider = new PrivatbankProvider($client, $logger);
        $provider->setUrl('');

        $expectedResult = [
            'USD' => new CurrencyValueDTO('PRIVATBANK', 'USD', 'UAH', '27.5', '28.1'),
            'EUR' => new CurrencyValueDTO('PRIVATBANK', 'EUR', 'UAH', '32.2', '33.3'),
        ];

        $this->assertEquals($expectedResult, $provider->getExchange());
    }

    public function testGetExchangeThrowsException(): void
    {
        $responseMock = $this->createMock(ResponseInterface::class);

        $client = $this->createMock(HttpClientInterface::class);
        $client->method('request')->willReturn($responseMock);

        $logger = $this->createMock(LoggerInterface::class);

        $provider = new PrivatbankProvider($client, $logger);
        $provider->setUrl('');

        $this->expectException(ProviderResponseException::class);
        $provider->getExchange();
    }
}

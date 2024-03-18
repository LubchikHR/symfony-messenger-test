<?php

declare(strict_types=1);

namespace App\Gateway;

use App\DTO\CurrencyValueDTO;
use Psr\Log\LoggerInterface;
use Symfony\Contracts\HttpClient\Exception\ExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

abstract class AbstractBankProvider
{
    private HttpClientInterface $client;
    public LoggerInterface $logger;
    private string $apiUrl;

    public function __construct(HttpClientInterface $client, LoggerInterface $logger)
    {
        $this->client = $client;
        $this->logger = $logger;

    }

    public function setUrl(string $url): void
    {
        $this->apiUrl = $url;
    }

    public function request(): ?array
    {
        try {
            $response = $this->client->request(
                'GET',
                $this->apiUrl,
            );

            if ($response->getStatusCode() === 200 && $response->getHeaders()) {
                return $response->toArray();
            }
        } catch (ExceptionInterface $exception) {
            $this->logger->error(
                sprintf(
                    'Message: %s ' . PHP_EOL . 'StackTrace: %s',
                    $exception->getMessage(),
                    $exception->getTraceAsString(),
                )
            );
        }

        return null;
    }

    /**
     * @return CurrencyValueDTO[]
     */
    public abstract function getExchange(): array;
}

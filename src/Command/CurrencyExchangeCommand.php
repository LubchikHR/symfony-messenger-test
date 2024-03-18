<?php

declare(strict_types=1);

namespace App\Command;

use App\DTO\CurrencyValueDTO;
use App\DTO\SubtractionRateDTO;
use App\Gateway\BankProviderInterface;
use App\MessageFactory\MessageFactory;
use App\Service\CurrencyService;
use App\Service\MessageService;
use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CurrencyExchangeCommand extends Command
{
    private const MESSAGE_TEMPLATE = 'Currency rate has been changed. Currency: %s, Subtraction [buy: %s, sell: %s]';
    public const THRESHOLD_PERCENTAGE = 1;

    private MessageService $messageService;
    private MessageFactory $messageFactory;
    private CurrencyService $currencyService;
    private LoggerInterface $logger;
    private array $providers;

    public function __construct(
        CurrencyService $currencyService,
        MessageService $messageService,
        MessageFactory $messageFactory,
        LoggerInterface $logger,
        array $providers,
        string $name = null
    ) {
        parent::__construct($name);

        $this->currencyService = $currencyService;
        $this->messageService = $messageService;
        $this->messageFactory = $messageFactory;
        $this->logger = $logger;

        $this->providers = $providers;
    }

    protected function configure()
    {
        $this->setName('app:currency-exchange');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        try {
            /** @var CurrencyValueDTO $exchangeRate */
            foreach ($this->getCurrencyExchangeRates() as $exchangeRate) {

                /** @var SubtractionRateDTO|null $subtractionRateDTO */
                $subtractionRateDTO = $this->currencyService->getDifferenceBetweenRates($exchangeRate);

                if (!is_null($subtractionRateDTO) &&
                    ($subtractionRateDTO->getSellDifference() > self::THRESHOLD_PERCENTAGE
                        || $subtractionRateDTO->getBuyDifference() > self::THRESHOLD_PERCENTAGE)
                ) {
                    $this->messageService->sendMessage(
                        $this->messageFactory->createSomeMessage(
                            sprintf(
                                self::MESSAGE_TEMPLATE,
                                $exchangeRate->getCurrency(),
                                $subtractionRateDTO->getBuyDifference(),
                                $subtractionRateDTO->getSellDifference(),
                            )
                        )
                    );
                }

                $this->currencyService->save($exchangeRate);
            }

        } catch (\Exception $exception) {
            $this->logger->error(sprintf(
                'Command: %s, Error message: %s, Trace: %s',
                $this->getName() . PHP_EOL,
                $exception->getMessage() . PHP_EOL,
                $exception->getTraceAsString() . PHP_EOL,
            ));

            return self::FAILURE;
        }

        return self::SUCCESS;
    }

    private function getCurrencyExchangeRates(): iterable
    {
        /** @var BankProviderInterface $provider */
        foreach ($this->providers as $provider) {
            foreach ($provider->getExchange() as $currencyValueDTO) {
                yield $currencyValueDTO;
            }
        }
    }
}

<?php

declare(strict_types=1);

namespace App\Service;

use App\Message\AsyncMessageInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\Messenger\MessageBusInterface;

class MessageService
{
    private MessageBusInterface $messageBus;
    private LoggerInterface $logger;

    public function __construct(MessageBusInterface $messageBus, LoggerInterface $logger)
    {
        $this->messageBus = $messageBus;
        $this->logger = $logger;
    }

    public function sendMessage(AsyncMessageInterface $message)
    {
        $this->logger->info(sprintf('Message has been prepared to send. Message: %s', $message->getContent()));
        $this->messageBus->dispatch($message);
        $this->logger->info('Message sent');
    }
}

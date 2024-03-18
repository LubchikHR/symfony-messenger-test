<?php

declare(strict_types=1);

namespace App\MessageHandler;

use Psr\Log\LoggerInterface;

class AbstractMessageHandler
{
    public LoggerInterface $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }
}

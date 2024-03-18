<?php

declare(strict_types=1);

namespace App\MessageHandler;

use App\Message\AsyncMessageInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class MessageHandler extends AbstractMessageHandler implements MessageHandlerInterface
{
    public function __invoke(AsyncMessageInterface $message)
    {
        if ($rand = rand(1,3) === 3) { // handling exceptional situations
            $this->logger->info(sprintf('Rand number is: %s', $rand));
            throw new \Exception('Something happened');
        }

        $this->logger->info($message->getContent());
    }
}

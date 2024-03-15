<?php

declare(strict_types=1);

namespace App\MessageHandler;

use App\Message\AsyncMessageInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class SomeMessageHandler implements MessageHandlerInterface
{
    public function __invoke(AsyncMessageInterface $message)
    {
        dump($message);
    }
}

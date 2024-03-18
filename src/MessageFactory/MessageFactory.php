<?php

declare(strict_types=1);

namespace App\MessageFactory;

use App\Message\AsyncMessageInterface;
use App\Message\SomeMessage;

class MessageFactory
{
    public function createSomeMessage(?string $content): AsyncMessageInterface
    {
        return new SomeMessage($content);
    }
}

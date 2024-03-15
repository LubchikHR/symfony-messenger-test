<?php

declare(strict_types=1);

namespace App\Service;

use App\Message\AsyncMessageInterface;
use Symfony\Component\Messenger\Exception\HandlerFailedException;
use Symfony\Component\Messenger\MessageBusInterface;

class SomeMessageService
{
    private MessageBusInterface $messageBus;

    public function __construct(MessageBusInterface $messageBus)
    {
        $this->messageBus = $messageBus;
    }

    public function sendMessage(AsyncMessageInterface $message)
    {
        try {
            $this->messageBus->dispatch($message);
        } catch (HandlerFailedException $exception) {
            // Обробка помилки відправки повідомлення в чергу failed
            // Ви можете записати інформацію про помилку, логувати її, або виконати інші дії
            // Якщо потрібно спробувати відправити повідомлення знову, це також можливо
            dump($exception);
        }
    }
}

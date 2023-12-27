<?php

declare(strict_types=1);

namespace App\Dispatcher\User;

use App\Message\User\IncreaseBalanceMessage;
use Symfony\Component\Messenger\MessageBusInterface;

final class IncreaseBalanceMessageDispatcher
{
    public function __construct(
        private MessageBusInterface $messageBus,
    ) {
    }

    public function dispatch(int $userId, float $amount): void
    {
        $message = new IncreaseBalanceMessage($userId, $amount);
        $this->messageBus->dispatch($message);
    }
}

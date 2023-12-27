<?php

declare(strict_types=1);

namespace App\Dispatcher\User;

use App\Message\User\DecreaseBalanceMessage;
use Symfony\Component\Messenger\MessageBusInterface;

final class DecreaseBalanceMessageDispatcher
{
    public function __construct(
        private MessageBusInterface $messageBus,
    ) {
    }

    public function dispatch(int $userId, float $amount): void
    {
        $message = new DecreaseBalanceMessage($userId, $amount);
        $this->messageBus->dispatch($message);
    }
}

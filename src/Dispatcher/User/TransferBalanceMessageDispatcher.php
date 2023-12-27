<?php

declare(strict_types=1);

namespace App\Dispatcher\User;

use App\Message\User\TransferBalanceMessage;
use Symfony\Component\Messenger\MessageBusInterface;

final class TransferBalanceMessageDispatcher
{
    public function __construct(
        private MessageBusInterface $messageBus,
    ) {
    }

    public function dispatch(int $fromUserId, int $toUserId, float $amount): void
    {
        $message = new TransferBalanceMessage($fromUserId, $toUserId, $amount);
        $this->messageBus->dispatch($message);
    }
}

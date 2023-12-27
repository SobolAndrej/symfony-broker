<?php

declare(strict_types=1);

namespace App\Message\User;

final class TransferBalanceMessage
{
    public function __construct(
        public readonly int $fromUserId,
        public readonly int $toUserId,
        public readonly float $amount,
    ) {
    }
}

<?php

declare(strict_types=1);

namespace App\Message\User;

final class IncreaseBalanceMessage
{
    public function __construct(
        public readonly int $userId,
        public readonly float $amount,
    ) {
    }
}

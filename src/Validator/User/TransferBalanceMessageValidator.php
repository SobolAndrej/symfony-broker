<?php

declare(strict_types=1);

namespace App\Validator\User;

use App\Message\User\TransferBalanceMessage;
use InvalidArgumentException;

class TransferBalanceMessageValidator
{
    public function validate(TransferBalanceMessage $message): void
    {
        if ($message->fromUserId <= 0) {
            throw new InvalidArgumentException('Invalid User From Provided');
        }
        if ($message->toUserId <= 0) {
            throw new InvalidArgumentException('Invalid User To Provided');
        }
        if ($message->amount <= 0) {
            throw new InvalidArgumentException('Invalid Amount Provided');
        }
    }
}

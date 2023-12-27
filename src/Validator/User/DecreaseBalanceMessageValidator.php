<?php

declare(strict_types=1);

namespace App\Validator\User;

use App\Message\User\DecreaseBalanceMessage;
use InvalidArgumentException;

class DecreaseBalanceMessageValidator
{
    public function validate(DecreaseBalanceMessage $message): void
    {
        if ($message->userId <= 0) {
            throw new InvalidArgumentException('Invalid User Provided');
        }
        if ($message->amount <= 0) {
            throw new InvalidArgumentException('Invalid Amount Provided');
        }
    }
}

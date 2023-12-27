<?php

declare(strict_types=1);

namespace App\Validator\User;

use App\Message\User\IncreaseBalanceMessage;
use InvalidArgumentException;

class IncreaseBalanceMessageValidator
{
    public function validate(IncreaseBalanceMessage $message): void
    {
        if ($message->userId <= 0) {
            throw new InvalidArgumentException('Invalid User Provided');
        }
        if ($message->amount <= 0) {
            throw new InvalidArgumentException('Invalid Amount Provided');
        }
    }
}

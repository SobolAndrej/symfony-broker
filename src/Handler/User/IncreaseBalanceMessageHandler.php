<?php

declare(strict_types=1);

namespace App\Handler\User;

use App\Message\User\IncreaseBalanceMessage;
use App\Service\User\UserBalanceService;
use App\Validator\User\IncreaseBalanceMessageValidator;
use Psr\Log\LoggerInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Throwable;

#[AsMessageHandler]
final class IncreaseBalanceMessageHandler
{
    public function __construct(
        private readonly UserBalanceService $userBalanceService,
        private readonly IncreaseBalanceMessageValidator $messageValidator,
        private readonly LoggerInterface $logger,
    ) {
    }

    public function __invoke(IncreaseBalanceMessage $message): void
    {
        try {
            $this->messageValidator->validate($message);
            $this->userBalanceService->increaseBalance($message->userId, $message->amount);
        } catch (Throwable $throwable) {
            $this->logger->error('Invalid message provided', [
                'error' => $throwable->getTrace(),
                'user' => $message->userId,
                'amount' => $message->amount,
            ]);
        }
    }
}

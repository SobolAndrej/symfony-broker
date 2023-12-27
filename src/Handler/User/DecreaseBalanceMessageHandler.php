<?php

declare(strict_types=1);

namespace App\Handler\User;

use App\Message\User\DecreaseBalanceMessage;
use App\Service\User\UserBalanceService;
use App\Validator\User\DecreaseBalanceMessageValidator;
use Psr\Log\LoggerInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Throwable;

#[AsMessageHandler]
final class DecreaseBalanceMessageHandler
{
    public function __construct(
        private readonly UserBalanceService $userBalanceService,
        private readonly DecreaseBalanceMessageValidator $messageValidator,
        private readonly LoggerInterface $logger,
    ) {
    }

    public function __invoke(DecreaseBalanceMessage $message): void
    {
        try {
            $this->messageValidator->validate($message);
            $this->userBalanceService->decreaseBalance($message->userId, $message->amount);
        } catch (Throwable $throwable) {
            $this->logger->error('Invalid message provided', [
                'error' => $throwable->getTrace(),
                'user' => $message->userId,
                'amount' => $message->amount,
            ]);
        }
    }
}

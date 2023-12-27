<?php

declare(strict_types=1);

namespace App\Handler\User;

use App\Message\User\TransferBalanceMessage;
use App\Service\User\UserBalanceService;
use App\Validator\User\TransferBalanceMessageValidator;
use Psr\Log\LoggerInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Throwable;

#[AsMessageHandler]
final class TransferBalanceMessageHandler
{
    public function __construct(
        private readonly UserBalanceService $userBalanceService,
        private readonly TransferBalanceMessageValidator $messageValidator,
        private readonly LoggerInterface $logger,
    ) {
    }

    public function __invoke(TransferBalanceMessage $message): void
    {
        try {
            $this->messageValidator->validate($message);
            $this->userBalanceService->transferBalance($message->fromUserId, $message->toUserId, $message->amount);
        } catch (Throwable $throwable) {
            $this->logger->error('Invalid message provided', [
                'error' => $throwable->getTrace(),
                'fromUser' => $message->fromUserId,
                'toUser' => $message->toUserId,
                'amount' => $message->amount,
            ]);
        }
    }
}

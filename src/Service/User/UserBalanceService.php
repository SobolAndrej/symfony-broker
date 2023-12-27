<?php

declare(strict_types=1);

namespace App\Service\User;

use App\Repository\UserRepository;
use Doctrine\ORM\EntityNotFoundException;
use InvalidArgumentException;

class UserBalanceService
{
    public function __construct(
        private readonly UserRepository $userRepository,
    ) {
    }

    public function increaseBalance(int $userId, float $amount): void
    {
        $user = $this->userRepository->find($userId);
        if (!$user) {
            throw new EntityNotFoundException("User with ID {$userId} not found");
        }
        $this->userRepository->updateUserBalance($user, $user->balance + $amount);
    }

    public function decreaseBalance(int $userId, float $amount): void
    {
        $user = $this->userRepository->find($userId);
        if (!$user) {
            throw new EntityNotFoundException("User with ID {$userId} not found");
        }
        if ($user->balance < $amount) {
            throw new InvalidArgumentException(
                "User with ID {$userId} has balance {$user->balance}. Can not minus {$amount} amount"
            );
        }
        $this->userRepository->updateUserBalance($user, $user->balance - $amount);
    }

    public function transferBalance(int $fromUserId, int $toUserId, float $amount): void
    {
        $fromUser = $this->userRepository->find($fromUserId);
        if (!$fromUser) {
            throw new EntityNotFoundException("From User with ID {$fromUserId} not found");
        }
        $toUser = $this->userRepository->find($toUserId);
        if (!$toUser) {
            throw new EntityNotFoundException("To User with ID {$toUserId} not found");
        }
        if ($fromUser->balance < $amount) {
            throw new InvalidArgumentException(
                "User with ID {$fromUserId} has balance {$fromUser->balance}. Can not minus {$amount} amount"
            );
        }
        $this->userRepository->transferUserBalance($fromUser, $toUser, $amount);
    }
}

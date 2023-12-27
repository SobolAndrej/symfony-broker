<?php

declare(strict_types=1);

namespace App\Tests\Service\User;

use App\Entity\User;
use App\Repository\UserRepository;
use App\Service\User\UserBalanceService;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class UserBalanceServiceTest extends KernelTestCase
{
    private readonly UserBalanceService $userBalanceService;
    private readonly UserRepository $userRepository;

    public function setUp(): void
    {
        parent::setUp();
        $app = self::bootKernel();
        /** @var UserBalanceService $userBalanceService */
        $userBalanceService = $app->getContainer()->get(UserBalanceService::class);
        $this->userBalanceService = $userBalanceService;
        /** @var UserRepository $userRepository */
        $userRepository = $app->getContainer()->get(UserRepository::class);
        $this->userRepository = $userRepository;
    }

    public function testSeveralOperations(): void
    {
        $users = $this->userRepository->findBy([], ['balance' => 'asc']);
        [$firstUser, $secondUser] = $users;

        $this->userBalanceService->increaseBalance((int) $firstUser->getId(), 2.2);
        $this->userBalanceService->decreaseBalance((int) $secondUser->getId(), 4.7);
        $this->userBalanceService->transferBalance((int) $secondUser->getId(), (int) $firstUser->getId(), 4.2);
        /** @var User $firstUser */
        $firstUser = $this->userRepository->find((int) $firstUser->getId());
        /** @var User $secondUser */
        $secondUser = $this->userRepository->find((int) $secondUser->getId());
        self::assertSame(16.4, round($firstUser->balance, 1));
        self::assertSame(11.1, round($secondUser->balance, 1));
    }
}

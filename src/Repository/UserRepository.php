<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<User>
 *
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    public function updateUserBalance(User $user, float $amount): void
    {
        $this->lockUser($user);
        $user->balance = $amount;
        $this->getEntityManager()->flush();
    }

    public function transferUserBalance(User $fromUser, User $toUser, float $amount): void
    {
        $this->lockUser($fromUser);
        $this->lockUser($toUser);
        $fromUser->balance -= $amount;
        $toUser->balance += $amount;
        $this->getEntityManager()->flush();
    }

    private function lockUser(User $user): void
    {
        $connection = $this->getEntityManager()->getConnection();
        $connection
            ->prepare('SELECT * FROM user WHERE id = :userId FOR UPDATE')
            ->executeQuery(['userId' => $user->getId()])
        ;
    }
}

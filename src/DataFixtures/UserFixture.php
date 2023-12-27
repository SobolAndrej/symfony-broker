<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class UserFixture extends Fixture
{
    public const FIRST_USER_REFERENCE = 'user1';
    public const SECOND_USER_REFERENCE = 'user2';

    public function load(ObjectManager $manager): void
    {
        $firstUser = new User();
        $firstUser->balance = 10;
        $manager->persist($firstUser);
        $this->addReference(self::FIRST_USER_REFERENCE, $firstUser);

        $secondUser = new User();
        $secondUser->balance = 20;
        $manager->persist($secondUser);
        $this->addReference(self::SECOND_USER_REFERENCE, $secondUser);

        $manager->flush();
    }
}

<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class UserFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $user = new User();
        $user->setEmail('test@test.com')
            ->setRoles(['ROLE_USER'])
            ->setPassword(password_hash('test', PASSWORD_DEFAULT));

        $user1 = new User();
        $user1->setEmail('admin@admin.com')
            ->setRoles(['ROLE_ADMIN'])
            ->setPassword(password_hash('admin', PASSWORD_DEFAULT));

        $manager->persist($user);
        $manager->persist($user1);
        $manager->flush();
    }
}

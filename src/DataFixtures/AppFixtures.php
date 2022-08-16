<?php

namespace App\DataFixtures;

use App\Entity\Todo;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $generator = Factory::create("fr_FR");

        for ($i = 0; $i <= 10; $i++) {
            $todo = new Todo();
            $todo->setName($generator->name);
            $todo->setCreatedAt($generator->dateTime);
            $todo->setIsCompleted(false);

            $manager->persist($todo);
        }
        $manager->flush();
    }
}
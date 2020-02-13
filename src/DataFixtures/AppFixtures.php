<?php

namespace App\DataFixtures;

use App\Entity\Task;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create("fr_FR");
        for($i = 0; $i < mt_rand(1, 100); $i ++){
            $user = new User();
            $user->setFirstName($faker->firstName())
                ->setLastName($faker->lastName);
            $manager->persist($user);

            for($j =0; $j < mt_rand(1, 25); $j ++) {
                $task = new Task();
                $task->setName($faker->name)
                    ->setTime($faker->text)
                    ->setPriority($faker->randomFloat(0, 20, 100))
                    ->setCreatedAt($faker->dateTime)
                    ->setUser($user);
                $manager->persist($task);
            }
        }
        // $product = new Product();
        // $manager->persist($product);

        $manager->flush();
    }
}

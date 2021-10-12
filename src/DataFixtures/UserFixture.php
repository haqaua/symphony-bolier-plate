<?php

namespace App\DataFixtures;

use App\Entity\Role;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class UserFixture extends Fixture
{
    public function load(ObjectManager $manager): void
    {
         $user = new User();
         $user->setFirstName('admin');
         $user->setLastName('admin');
         $user->setEmail('admin@example.com');
         $user->setPassword('$2y$13$Mk3izbJZu2C2yK4gGLQMteJi7yby9MJpoE7/v8y08iOZb8Mr3ahZ.');

         $role = new Role('Administrator');
         $role->addUsers($user);
         $user->setRole($role);
         $manager->persist($user);

        $manager->flush();
    }
}

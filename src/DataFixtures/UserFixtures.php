<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->hasher = $hasher;
    }

    public function load(ObjectManager $manager): void
    {
        // Add admin demo
        $user = new User;
        $user->setUsername('admin');
        $user->setRoles(['ROLE_ADMIN']);
        $user->setFirstName('Trung');
        $user->setLastName('Ha');
        $user->setPassword($this->hasher->hashPassword($user, "123456"));
        $manager->persist($user);

        $manager->flush();
    }
}
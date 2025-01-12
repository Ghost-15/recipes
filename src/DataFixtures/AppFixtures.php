<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    public function __construct(private readonly UserPasswordHasherInterface $passwordHasher){}

    public function load(ObjectManager $manager): void
    {
        $app = new User();

        $app->setUsername('u');
        $app->setEmail('user@mail.com');
        $app->setPassword($this->passwordHasher->hashPassword($app, 'test'));
        $app->setRoles(['ROLE_USER']);

        $manager->persist($app);
        $manager->flush();
    }
}

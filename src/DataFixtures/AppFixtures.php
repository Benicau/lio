<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $user = new User();
        $user->setEmail('l.c.elec7700@gmail.com');
        $user->setRoles(['ROLE_ADMIN']);
        
        // Utilisation de password_hash() pour hacher le mot de passe
        $hashedPassword = password_hash('Verdure7a', PASSWORD_BCRYPT, ['cost' => 13]);
        $user->setPassword($hashedPassword);

        $manager->persist($user);
        $manager->flush();
    }
}


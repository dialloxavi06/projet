<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Entity\Projet;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use App\Enum\StatutTâche;

class UserFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        // Création de l'utilisateur admin
        $admin = new User();
        $admin->setEmail('admin@gmail.com');
        $admin->setRoles(['ROLE_ADMIN']);
        $admin->setPassword(password_hash('admin', PASSWORD_BCRYPT));
        $admin->setNom($faker->lastName);
        $admin->setPrenom($faker->firstName);
        $manager->persist($admin);

        // Création de 15 utilisateurs avec des projets
        for ($i = 0; $i < 15; $i++) {
            $user = new User();
            $user->setEmail($faker->email);
            $user->setRoles(['ROLE_USER']);
            $user->setPassword(password_hash($faker->password, PASSWORD_BCRYPT));
            $user->setNom($faker->lastName);
            $user->setPrenom($faker->firstName);

            for ($j = 0; $j < 5; $j++) {
                $projet = new Projet();
                $projet->setName($faker->word);
                $projet->setDescription($faker->sentence);
                $projet->setStatus(StatutTâche::Termine);
                
                // Utilisation des références pour récupérer une échéance et un projet

                $projetReference = $this->getReference('projet_' . random_int(0, 14));
                $user->addProjet($projetReference);

                $manager->persist($projet);
            }

            $manager->persist($user);
        }

        $manager->flush();
    }
}
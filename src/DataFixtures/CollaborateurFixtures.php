<?php

// src/DataFixtures/CollaborateurFixture.php

namespace App\DataFixtures;

use App\Entity\Collaborateur;
use App\Entity\Projet;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use App\Enum\StatutTâche;


class CollaborateurFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        for ($i = 0; $i < 15; $i++) {
            $collaborateur = new Collaborateur();
            $collaborateur->setNom($faker->lastName);
            $collaborateur->setPrenom($faker->firstName);
            $collaborateur->setAdressMail($faker->email);

            for ($j = 0; $j < 5; $j++) {
                $projet = new Projet();
                $projet->setStatus(StatutTâche::Termine); 
                $projet->setName($faker->word);

                $collaborateur->addProjet($projet);

                $manager->persist($projet);
            }

            $manager->persist($collaborateur);
        }

        $manager->flush();
    }
}


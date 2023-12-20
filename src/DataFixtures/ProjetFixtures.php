<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Projet;
use App\Enum\StatutTâche;
use Faker\Factory;



class ProjetFixtures extends Fixture
{public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        for ($i = 0; $i < 15; $i++) {
            $projet = new Projet();
            $projet->setStatus(StatutTâche::EnCours); 
            $projet->setName($faker->word);
            $projet->setDescription($faker->sentence);

             // Ajout d'une référence pour pouvoir l'utiliser dans d'autres fixtures
             $this->addReference('projet_' . $i, $projet);
            $manager->persist($projet);
        }

        $manager->flush();
    }
}

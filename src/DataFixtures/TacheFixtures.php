<?php
// src/DataFixtures/TacheFixture.php

namespace App\DataFixtures;

use App\Entity\Tache;
use App\Entity\Projet;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use App\Enum\StatutTâche;


class TacheFixture extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        for ($i = 0; $i < 15; $i++) {
            $tache = new Tache();
            $tache->setTitre($faker->sentence);
            $tache->setDescription($faker->paragraph);
            $tache->setStatus(StatutTâche::EnCours);

            $projet = new Projet();
            $projet->setName($faker->word);
            $projet->setStatus(StatutTâche::Termine); 

            $tache->setProjet($projet);

            $manager->persist($projet);
            $manager->persist($tache);
        }

        $manager->flush();
    }
}


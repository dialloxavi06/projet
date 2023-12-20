<?php

namespace App\DataFixtures;

use App\Entity\Echeance;
use App\Entity\Projet;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class EcheanceFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        for ($i = 0; $i < 15; $i++) {
            $echeance = new Echeance();
            $echeance->setDate(\DateTimeImmutable::createFromMutable($faker->dateTimeBetween('now', '+1 year')));
            $echeance->setDescription($faker->sentence);

            $manager->persist($echeance);

            // Ajout d'une référence pour pouvoir l'utiliser dans d'autres fixtures
            $this->addReference('echeance_' . $i, $echeance);
        }

        $manager->flush();
    }
}
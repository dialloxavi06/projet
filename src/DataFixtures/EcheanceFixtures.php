<?php
// src/DataFixtures/EcheanceFixture.php

namespace App\DataFixtures;

use App\Entity\Echeance;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class EcheanceFixture extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        // Create more than 10 echeances
        for ($i = 0; $i < 15; $i++) {
            $echeance = new Echeance();
            $echeance->setDate(\DateTimeImmutable::createFromMutable($faker->dateTimeBetween('now', '+1 year')));
            $echeance->setDescription($faker->sentence);

            $manager->persist($echeance);
        }

        $manager->flush();
    }
}


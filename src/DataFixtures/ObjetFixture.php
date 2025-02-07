<?php

namespace App\DataFixtures;

use Faker\Factory;
use Faker\Generator;
use App\Entity\Objet;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class ObjetFixture extends Fixture
{   
    private Generator $faker;

    public function __construct()
    {
        $this->faker = Factory::create('fr_FR');
    }

    public function load(ObjectManager $manager): void
    {
        for ($i = 0; $i < 10; $i++) {
            $objet = new Objet();
            $objet->setTitre($this->faker->word());
            $objet->setImage($this->faker->imageUrl());
            $objet->setDescription($this->faker->text()); 
            $objet->setIsActive($this->faker->boolean());

            $manager->persist($objet);
        }

        $manager->flush();
    }
}

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
 
    }
}

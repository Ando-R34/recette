<?php

namespace App\DataFixtures;

use App\Entity\Engredient;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Faker\Generator;

class AppFixtures extends Fixture
{
    private Generator $faker;

    public function __construct()
    {   
        $this->faker = Factory::create('fr_FR') ;
    }

    public function load(ObjectManager $manager): void
    {
        for ($i=1; $i < 50; $i++) { 
            $ingredient = new Engredient();
            $ingredient->setName($this->faker->word())
                    ->setPrice(mt_rand(1 ,100));
            $manager->persist($ingredient);
        }
        
        
        $manager->flush();
    }
}

<?php

namespace App\DataFixtures;

use App\Entity\Peinture;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class PeintureFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {

        $faker = Factory::create('fr_FR');
        for ($i=0; $i < 10; $i++) { 
            $peinture = new Peinture();
            $peinture->setName($faker->name);
            $peinture->setDescription($faker->sentence);
            $peinture->setPrice($faker->randomFloat(2));
            $peinture->setLargeur($faker->numberBetween(2,50));
            $peinture->setHauteur($faker->numberBetween(2,50));
            $peinture->setFile('img/placeholder.jpg');
        }
        // $product = new Product();
        // $manager->persist($product);

        $manager->flush();
    }
}

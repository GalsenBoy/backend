<?php

namespace App\DataFixtures;

use App\Entity\Article;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class ArticlesFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
       $faker = Factory::create();

       for ($i=0 ; $i <15 ; $i++) { 
        $articles = new Article();
        $articles->setName($faker->sentence);
        $articles->setContent($faker->paragraph);
        $manager->persist($articles);
       }
        $manager->flush();
    }
}

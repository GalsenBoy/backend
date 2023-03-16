<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Repository\ArticleRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class CategoryFixtures extends Fixture
{
    private $articleRepository;

    public function __construct(ArticleRepository $articleRepository)
    {
        $this->articleRepository = $articleRepository;
    }
    public function load(ObjectManager $manager): void
    {
       $faker = Factory::create();

       for ($i=0 ; $i <15 ; $i++) { 
        $category = new Category();
        $category->setName($faker->sentence);
        $category->setDescription($faker->paragraph);
        $articles = $this->articleRepository->findAll();
        
        $randomArticles = $faker->randomElements($articles, $count = 3);
        foreach ($randomArticles as $article) {
            $category->addArticle($article);
        }
        $manager->persist($category);
       }
        $manager->flush();
    }
}

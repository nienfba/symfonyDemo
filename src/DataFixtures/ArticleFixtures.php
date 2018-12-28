<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Article;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class ArticleFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');
        
        for($i=1; $i < 5;$i++)
        {
            $article = new Article();
            $article->setTitle($faker->sentence())
                    ->setCreatedAt($faker->dateTimeBetween('-2 months'))
                    ->setImage($faker->imageUrl())
                    ->setContent('<p>'.join($faker->paragraphs(3),'</p><p>'),'</p>');
            
            $manager->persist($article);
            $manager->flush();
        }

        $manager->flush();
    }
}

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
        /** Problème avec Faker et cURL pour récupérer une image
         * Je tdétourne le problème en générant une image puis en l'écrivant avec copy
         * Le praramètre allow_url_fopen de php doit-être à vrai ! 
         *
         */

        $faker = Factory::create('fr_FR');

        for($i=1; $i < 15;$i++)
        {
            /** Hack image temporaire ! A tester cUrl plus en profondeur*/
            $dir = 'public/uploads/articles';
            $url = $faker->imageUrl(724, 400);
            $name = md5(uniqid(empty($_SERVER['SERVER_ADDR']) ? '' : $_SERVER['SERVER_ADDR'], true));
            $filename = $name .'.jpg';
            $filepath = $dir . DIRECTORY_SEPARATOR . $filename;
            //$fp = fopen($filepath, 'w');
            $success = copy($url, $filepath);

            $article = new Article();
            $article->setTitle($faker->sentence())
                    ->setCreatedAt($faker->dateTimeBetween('-2 months'))
                    ->setImage($filename)
                    ->setContent('<p>'.join($faker->paragraphs(3),'</p><p>').'</p>');
            
            $manager->persist($article);
            $manager->flush();

            //print 
        }

        $manager->flush();
    }
}

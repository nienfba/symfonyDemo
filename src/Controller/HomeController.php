<?php

namespace App\Controller;

use App\Entity\Article;
use App\Repository\ArticleRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index()
    {

        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }

    /**
     * @Route("/blog", name="blog")
     */
    public function blog(ArticleRepository $repo)
    {
        $articles = $repo->findAll();
        return $this->render('home/blog.html.twig', [
            'title' => 'Bienvenue sur mon Blog',
            'articles' => $articles
        ]);
    }

     /**
     * @Route("/blog/view/{id}", name="view_article")
     */
    public function view(Article $article)
    {
        return $this->render('home/view.html.twig', [
            'title' => 'Détail de l\'article',
            'article' => $article
        ]);
    }
}

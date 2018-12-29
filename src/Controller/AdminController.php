<?php

namespace App\Controller;

use Faker\Factory;
use App\Entity\Article;
use App\Form\ArticleType;
use App\Repository\ArticleRepository;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

class AdminController extends AbstractController
{
    /**
     * @Route("/admin/article/", name="article_liste")
     */
    public function index(ArticleRepository $repo)
    {
        $articles = $repo->findAll();
        return $this->render('admin/index.html.twig', [
            'articles' => $articles,
        ]);
    }

    /**
     * @Route("/admin/article/add", name="article_create")
     * @Route("/admin/article/{id}/edit/", name="article_edit")
     */
    public function article(Article $article = null, Request $request,ObjectManager $manager)
    {
        if($article == null)
            $article = new Article();
        
        $form = $this->createForm(ArticleType::class, $article);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            if(!$article->getId())
                $article->setCreatedAt(new \DateTime());

            $manager->persist($article);
            $manager->flush();

            return $this->redirectToRoute('article_liste');
        }

        return $this->render('admin/create.html.twig', [
            'formArticle'=>$form->createView(),
            'edit' => $article->getId() !== null
        ]);
    }

     /**
     * @Route("/admin/article/{id}/del/", name="article_del")
     */
    public function delArticle(Article $article = null,  ObjectManager $manager)
    {
        if($article !== null)
        {
            $manager->remove($article);
            $manager->flush();
        }
        return $this->redirectToRoute('article_liste');
    }
}

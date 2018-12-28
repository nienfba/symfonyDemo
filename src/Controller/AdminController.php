<?php

namespace App\Controller;

use App\Entity\Article;
use App\Form\ArticleType;
use App\Repository\ArticleRepository;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
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

            /** Upload de l'image https://symfony.com/doc/current/controller/upload_file.html */
            $file = $article->getImage();
            $fileName = md5(uniqid()).'.'.$file->guessExtension();

            $article->setImage($fileName);
            try {
                // Voir config/services.yaml pour param articles_directory
                $file->move($this->getParameter('articles_directory'),$fileName);
            } catch (FileException $e) {
                $article->setImage(null);
            }

            $manager->persist($article);
            $manager->flush();

            return $this->redirectToRoute('article_liste');
        }

        return $this->render('admin/create.html.twig', [
            'formArticle'=>$form->createView(),
            'editMode' => $article->getId() !== null
        ]);
    }
}

<?php

namespace App\Controller\BackOffice;

use App\Entity\Article;
use App\Form\ArticleType;
use App\Repository\ArticleRepository;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

class ArticleController extends AbstractController
{
    /**
     * @var ArticleRepository
     */
    private $articleRepository;
    
    public function __construct(ArticleRepository $articleRepository) {
        $this->articleRepository = $articleRepository;
    }

    
    /**
     * @Route("/backoffice/articles", name="back_office_articles")
     * @return Response
     */
    public function articles(): Response
    {
        return $this->render('back_office/tables.html.twig', [
            'entity' => Article::class,
            'list' => $this->articleRepository->findAll()
        ]);
    }
    
    /**
     * @Route("/backoffice/article/new", name="back_office_article_new")
     * @return Response
     */
    public function new(Request $request): Response
    {
        $post = new Article();
        $form = $this->createForm(ArticleType::class, $post, []);
        $form->handleRequest($request);
        
        if ($request->isMethod('POST') && $form->isValid()) {
            $this->saveOrUpdate($post);
            $request->getSession()->getFlashBag()->add('notice', 'message.update.ok');
            return $this->redirectToRoute('back_office_articles');
        }
        
        return $this->render('back_office/article/form.html.twig', [
            'form' => $form->createView(),
        ]);
    }
    
    /**
     * @Route("/backoffice/article/edit/{id<\d+>}", name="back_office_article_edit")
     */
    public function edit(int $id, Request $request): Response 
    {
        $post = $this->articleRepository->findOneBy(['id' => $id]);
        
        $form = $this->createForm(ArticleType::class, $post, []);
        $form->handleRequest($request);

        if ($request->isMethod('POST') && $form->isValid()) {
            $this->saveOrUpdate($post);
            $request->getSession()->getFlashBag()->add('notice', 'message.update.ok');
        }

        return $this->render('back_office/article/form.html.twig', [
            'form' => $form->createView(),
        ]);
    }
    
    /**
     * Methode pour créer ou modifier un article
     * @param Article $article
     * @throws \App\Controller\BackOffice\Exception
     */
    private function saveOrUpdate(Article $article)
    {
        /* @var $entityManager Doctrine\ORM\EntityManager */
        $entityManager = $this->getDoctrine()->getManager();

        try {
            $entityManager->getConnection()->beginTransaction();
            
            if($article->getDateCreation() === null) {
                $article->setDateCreation(new \DateTime());
            }
            $article->setDateModification(new \DateTime());
            
            $entityManager->persist($article);
            $entityManager->flush();
            $entityManager->getConnection()->commit();
        } catch (Exception $e) {
            $entityManager->getConnection()->rollback();
            throw $e;
        }
    }
}

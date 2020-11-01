<?php

namespace App\Controller\FrontOffice;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use App\Repository\ArticleRepository;
use App\Repository\ParametreRepository;
use App\Repository\WebPageRepository;

/**
 * 
 */
class FrontController extends GenericController
{

    
    
    /**
     * @return Response
     * @Route("/", name="homepage")
     */
    public function homepage(): Response
    {
        $this->init();
        return $this->render($this->skin.'/homepage.html.twig', [
            //'controller_name' => 'MainController',
        ]);
    }
    
    /**
     * Affiche de l'article
     * @return Response
     * @Route("/post/{slug}", name="article_page")
     */
    public function article(string $slug): Response
    {
        $this->init();
        $article = $this->articleRepository->findOneBy(['slug'=>$slug]);
        
        return $this->render($this->skin.'/article.html.twig', [
            'article' => $article,
        ]);
    }
    
    /**
     * Affiche les différentes pages renseignées du site
     * @return Response
     */
    public function menuTopPages(): Response
    {
        $pages = $this->webpageRepository->findAll();
        return $this->render($this->skin.'/_trans/menu.top.pages.html.twig', [
            'pages' => $pages
        ]);
    }
    
    /**
     * @var ArticleRepository 
     */
    private $articleRepository;
    /**
     * @var WebPageRepository 
     */
    private $webpageRepository;
    
    public function __construct(ParametreRepository $paramRepository, ArticleRepository $articleRepository,
        WebPageRepository $webpageRepository) {
        parent::__construct($paramRepository);
        
        $this->articleRepository = $articleRepository;
        $this->webpageRepository = $webpageRepository;
    }
}

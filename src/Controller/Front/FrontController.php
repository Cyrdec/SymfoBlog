<?php

namespace App\Controller\Front;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use App\Repository\ArticleRepository;
use App\Repository\EditoRepository;
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
        // Récupération du dernier édito (en fonction de la date de publication)
        $edito = $this->editoRepository->findLastEdito();
        $articles = $this->articleRepository->findLastArticle(4);
        
        return $this->myRender('/pages/homepage.html.twig', [
            'skin' => $this->skin, 
            'edito' => $edito,
            'articles' => $articles
        ]);
    }
    
    /**
     * Affiche de l'article
     * @return Response
     * @Route("/article/{slug}", name="article_page")
     */
    public function article(string $slug): Response
    {
        $article = $this->articleRepository->findOneBy(['slug'=>$slug]);

        if($article !== null) {
            return $this->myRender('/pages/article.html.twig', [
                'article' => $article,
            ]);
        } else {
            return $this->myRender('/_error/404.html.twig', [
            ]);
        }
    }
    
    /**
     * Affiche de la page demandée
     * @return Response
     * @Route("/page/{slug}", name="webpage_page")
     */
    public function webpage(string $slug): Response
    {
        $webpage = $this->webpageRepository->findOneBy(['slug'=>$slug]);

        if($webpage !== null) {
            return $this->myRender('/pages/webpage.html.twig', [
                'webpage' => $webpage,
            ]);
        } else {
            return $this->myRender('/_error/404.html.twig', [
            ]);
        }
    }
    
    /**
     * Affiche les différentes pages dans le menu d'entête du site
     * @return Response
     */
    public function menuTopPages(): Response
    {
        $pages = $this->webpageRepository->header();
        return $this->myRender('/_trans/menu.top.pages.html.twig', [
            'pages' => $pages
        ]);
    }
    
    /**
     * Affiche les différentes pages dans le footer du site
     * @return Response
     */
    public function menuBottomPages(): Response
    {
        $pages = $this->webpageRepository->footer();
        return $this->myRender('/_trans/footer.pages.html.twig', [
            'pages' => $pages
        ]);
    }
    
    /**
     * @var EditoRepository
     */
    private $editoRepository;
    /**
     * @var ArticleRepository 
     */
    private $articleRepository;
    /**
     * @var WebPageRepository 
     */
    private $webpageRepository;
    
    public function __construct(EditoRepository $editoRepository, ParametreRepository $paramRepository, 
            ArticleRepository $articleRepository, WebPageRepository $webpageRepository) 
    {
        parent::__construct($paramRepository);
        $this->editoRepository = $editoRepository;
        $this->articleRepository = $articleRepository;
        $this->webpageRepository = $webpageRepository;
    }

}
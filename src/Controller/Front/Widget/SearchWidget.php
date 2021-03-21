<?php

namespace App\Controller\Front\Widget;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

use App\Controller\WidgetInterface;
use App\Entity\Article;

/**
 * Description of SearchWidget
 *
 * @author cedric
 * @Route("/search", name="")
 */
class SearchWidget extends AbstractController implements WidgetInterface {
    
    public function getName(): string 
    {
        return SearchWidget::class;
    }
    
    public function getMethod(): string 
    {
        return 'show';
    }

    public function show() 
    {
        return $this->render('widgets/search.html.twig');
    }
    
    public function attributes(): array
    {
        return [];
    }

    /**
     * @Route("/full", name="widget_search_search")
     */
    public function detail(Request $request)
    {
        //$categorie = $this->getDoctrine()->getRepository(Categorie::class)->findOneBy(['slug' => $slug]);
        $texte = $request->get('texte');
        $resultat = [];
        $resultat = array_merge($resultat, $this->getDoctrine()->getRepository(Article::class)->searchWord($texte));
        
        return $this->render('widgets/search/result.html.twig',[
            'skin' => 'front_office_bpost',
            'texte' => $texte,
            'listing' => $resultat
        ]);
    }
}

<?php

namespace App\Controller\Front\Widget;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

use App\Controller\WidgetInterface;
use App\Entity\Categorie;
use App\Repository\CategorieRepository;
    
/**
 * Description of CategorieWidget
 *
 * @author cedric
 * @Route("/categorie", name="")
 */
class CategorieWidget extends AbstractController implements WidgetInterface 
{

    /**
     * @param string $skin
     */
    private $skin;
    
    public function getName(): string 
    {
        return CategorieWidget::class;
    }
    
    public function getMethod(): string 
    {
        return 'show';
    }

    public function show() 
    {
        return $this->render('widgets/categories.html.twig',[
            'list' => $this->getDoctrine()->getRepository(Categorie::class)->findAll()
        ]);
    }
    
    public function attributes(): array
    {
        return [];
    }
    
    /**
     * @Route("/{slug}", name="blog_widget_categories_slug")
     */
    public function detail(string $slug)
    {
        $categorie = $this->getDoctrine()->getRepository(Categorie::class)->findOneBy(['slug' => $slug]);

        return $this->render('widgets/categories/liste.html.twig',[
            'skin' => 'front_office_bpost',
            'categorie' => $categorie
        ]);
    }
}

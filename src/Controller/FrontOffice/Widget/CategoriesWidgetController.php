<?php
namespace App\Controller\FrontOffice\Widget;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Repository\CategorieRepository;

/**
 * Description of CategoriesWidgetController
 *
 * @author cedric
 */
class CategoriesWidgetController extends AbstractController 
{
    const SKIN = 'front_office_bpost';
    /**
     * @var CategorieRepository 
     */
    private $repository;
    
    /**
     * 
     * @param CategorieRepository $categorieRepository
     */
    public function __construct(CategorieRepository $categorieRepository) {
        $this->repository = $categorieRepository;
    }
    
    public function launch()
    {
        $categories = $this->repository->findAll();
        
        return $this->render(self::SKIN.'/widget/categories.widget.html.twig', [
            'list' => $categories
        ]);
    }
}

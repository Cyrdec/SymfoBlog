<?php

namespace App\Controller\FrontOffice;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Repository\ParametreRepository;

/**
 * Description of GenericController
 *
 * @author cedric
 */
class GenericController extends AbstractController
{
    /**
     * @param string
     */
    protected $skin;
    
    public function init()
    {
        $this->skin = $this->paramRepository->findOneBy(['cle' => $this->getParameter('app.params.skin')])->getValeur();
    }
    
    /**
     * Constructeur 
     * @param ParametreRepository $paramRepository
     */
    public function __construct(ParametreRepository $paramRepository) {
        $this->paramRepository = $paramRepository;
    }
    
    
    /**
     * @var ParametreRepository 
     */
    private $paramRepository;
}

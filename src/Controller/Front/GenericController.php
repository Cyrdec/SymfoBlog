<?php

namespace App\Controller\Front;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Yaml\Yaml;
use Symfony\Component\HttpFoundation\Response;

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
    
    public function myRender(string $template, array $params): Response
    {
        $skinName = $this->blogParams['parameters']['app.params.skin'];
        $skinValue = $this->paramRepository->findOneBy(['cle' => $skinName])->getValeur();
        $params = array_merge($params, ['skin' => $skinValue]);
        
        $params = array_merge($params, ['imgLogo' => $this->blogParams['parameters']['logo.image']]);
        $params = array_merge($params, ['labelLogo' => $this->blogParams['parameters']['logo.label']]);
        
        return $this->render($skinValue.$template, $params);
    }
    
    /**
     * Constructeur 
     * @param ParametreRepository $paramRepository
     */
    public function __construct(ParametreRepository $paramRepository) {
        $this->blogParams = Yaml::parseFile('../config/blog.yaml');
        $this->paramRepository = $paramRepository;
    }
    
    /**
     * @var array
     */
    private $blogParams;
    /**
     * @var ParametreRepository 
     */
    protected $paramRepository;
}

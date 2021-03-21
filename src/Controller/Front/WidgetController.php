<?php

namespace App\Controller\Front;

use Symfony\Component\Yaml\Yaml;
use Symfony\Component\HttpFoundation\Response;

use App\Repository\ParametreRepository;

/**
 * Description of WidgetController
 *
 * @author cedric
 */
class WidgetController extends GenericController
{
    
    /**
     * Affichage de la Side bar
     * @return type
     */
    public function sidebar(): Response
    {
        $sideBarWidgets = $this->yaml['widgets']['sidebar'];
        
        $widgets = [];
        foreach($sideBarWidgets as $name) {
            $widgets[] = $this->widgets[$name];
        }
        return $this->myRender('/_trans/side.bar.html.twig', [
            'sideBarWidgets' => $widgets
        ]);
    }
    
    /**
     * Méthode d'intialisation des Widgets
     * @return array
     */
    private function init(): array
    {
        $widgets = [];
        $implementWidgets = $this->yaml['widgets']['implement'];
        foreach($implementWidgets as $name => $object) {
            $widget = new $object['class']();
            
            // On récupère les paramètres si existant
            if(array_key_exists('params', $object)) {
                foreach($object['params'] as $key => $value) {
                    $parametre = $this->paramRepository->findOneBy(['cle' => $value]);
                    if($parametre !== null) {
                        $widget->__set($key, $parametre->getValeur());
                    }
                }
            }
            $widgets = array_merge($widgets, [$name => $widget]);
        }
        return $widgets;
    }


    /**
     * @var array
     */
    private $widgets;
    /**
     * @return array
     */
    private $yaml;

    /**
     * Constructeur par défaut
     * @param ParametreRepository $paramRepository
     */
    function __construct(ParametreRepository $paramRepository) 
    {
        parent::__construct($paramRepository);
        $this->yaml = Yaml::parseFile('../config/widgets.yaml');
        $this->widgets = $this->init();
    }
    
}

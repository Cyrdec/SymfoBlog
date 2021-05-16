<?php

namespace App\Controller\Front;

use Symfony\Component\Yaml\Yaml;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Psr\Log\LoggerInterface;

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
    	  $skinName = $this->siteParams['parameters']['app.params.skin'];
        $skin = $this->paramRepository->findOneBy(['cle' => $skinName])->getValeur();
        
        $widgets = [];
        $implementWidgets = $this->yaml['widgets']['implement'];
        foreach($implementWidgets as $name => $object) {
            $widget = new $object['class']();
            //$widget->__set('skin', $skin);
            
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
     * @return array
     */
    private $siteParams;

    /**
     * Constructeur par défaut
     * @param ParametreRepository $paramRepository
     */
    function __construct(MailerInterface $mailer, LoggerInterface $logger, ParametreRepository $paramRepository) 
    {
        parent::__construct($mailer, $logger, $paramRepository);
        
        $this->yaml = Yaml::parseFile('../config/widgets.yaml');
        $this->siteParams = Yaml::parseFile('../config/site.yaml');
        
        $this->widgets = $this->init();
    }
    
}

<?php

namespace App\Controller\Front\Widget;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

use App\Controller\WidgetInterface;


/**
 * Description of SideWidget
 *
 * @author cedric
 */
class TextWidget extends AbstractController implements WidgetInterface 
{
    /**
     * @var string
     */
    private $titre;
    /**
     * @var string
     */
    private $contenu;
    
    /**
     * @param string $skin
     */
    private $skin;
    
    public function getName(): string 
    {
        return TextWidget::class;
    }
    
    public function getMethod(): string 
    {
        return 'show';
    }

    /**
     * Methode d'affichage du Widget
     * @param string $titre
     * @param string $contenu
     * @return Response
     */
    public function show(string $titre = null, string $contenu = null): Response
    {
        return $this->render('widgets/text.html.twig',[
            'titre' => $titre,
            'contenu' => $contenu
        ]);
    }
    
    public function attributes(): array
    {
        return [
            'titre' => $this->titre,
            'contenu' => $this->contenu
        ];
    }

    public function __set(string $key, ?string $value) {
        $this->$key = $value;
    }

}

<?php

namespace App\Controller\FrontOffice\Widget;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * Description of TextWidgetController
 *
 * @author cedric
 */
class TextWidgetController  extends AbstractController 
{
    const SKIN = 'front_office_bpost';
    
    public function launch()
    {
        return $this->render(self::SKIN.'/widget/text.widget.html.twig', [
        ]);
    }
}
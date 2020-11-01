<?php

namespace App\Controller\FrontOffice\Widget;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * Description of SearchWidgetController
 *
 * @author cedric
 */
class SearchWidgetController  extends AbstractController 
{
    const SKIN = 'front_office_bpost';
    
    public function launch()
    {
        return $this->render(self::SKIN.'/widget/search.widget.html.twig', [
        ]);
    }
}

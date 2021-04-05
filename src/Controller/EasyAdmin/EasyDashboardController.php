<?php

namespace App\Controller\EasyAdmin;

use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Config\Assets;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use App\Entity\Edito;
use App\Entity\Page;
use App\Entity\Tag;
use App\Entity\Article;
use App\Entity\Categorie;
use App\Entity\Commentaire;
use App\Entity\Parametre;


class EasyDashboardController extends AbstractDashboardController
{
    /**
     * @Route("/admin", name="easyadmin")
     */
    public function index(): Response
    {
        //return parent::index();
        return $this->render('bundles/easyadmin.welcome.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('BackOffice<sup>v1</sup>')
            ;
    }
    
    public function configureAssets(): Assets {
        return Assets::new()->addCssFile('bundles/easyadmin.css');
    }
    
    public function configureMenuItems(): iterable {
        //yield MenuItem::linktoDashboard('Dashboard', 'fa fa-home');

        yield MenuItem::section('Interface', 'fa fa-sitemap')->setCssClass('section');
        yield MenuItem::linkToCrud('Edito', 'fa fa-keyboard', Edito::class);
        yield MenuItem::linkToCrud('Pages', 'fa fa-file', Page::class);
        yield MenuItem::linkToCrud('Tag', 'fa fa-tag', Tag::class);
        
        yield MenuItem::section('Blog', 'fa fa-blog')->setCssClass('section');
        yield MenuItem::linkToCrud('Article', 'fa fa-newspaper', Article::class);
        yield MenuItem::linkToCrud('Catégorie', 'fa fa-folder-open', Categorie::class);
        yield MenuItem::linkToCrud('Commentaire', 'fa fa-comment', Commentaire::class);
        
        yield MenuItem::section('Configuration', 'fa fa-ellipsis-v')->setCssClass('section');
        yield MenuItem::linkToCrud('Paramétrage', 'fa fa-cog', Parametre::class);
        

        yield MenuItem::section('')->setCssClass('section');
        yield MenuItem::linkToUrl('EasyAdmin', 'fa fa-tools', 'https://github.com/EasyCorp/EasyAdminBundle')->setLinkTarget('_blank')->setLinkRel('noreferrer');
        yield MenuItem::linkToUrl('Retour Front', 'fa fa-backward', $this->generateUrl('homepage'))->setCssClass('synthese');
    }
}

<?php

namespace App\Controller\EasyAdmin;

use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Config\Assets;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


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
    
    public function configureMenuItems(): iterable
    {
        //yield MenuItem::linktoDashboard('Dashboard', 'fa fa-home');
        
        yield MenuItem::section('Interface', 'fa fa-sitemap')->setCssClass('section');
        yield MenuItem::linkToCrud('Pages', 'fa fa-file', \App\Entity\WebPage::class);
        yield MenuItem::linkToCrud('Tag', 'fa fa-tag', \App\Entity\Tag::class);
        
        yield MenuItem::section('Blog', 'fa fa-blog')->setCssClass('section');
        yield MenuItem::linkToCrud('Article', 'fa fa-newspaper', \App\Entity\Article::class);
        yield MenuItem::linkToCrud('Catégorie', 'fa fa-folder-open', \App\Entity\Categorie::class);
        yield MenuItem::linkToCrud('Commentaire', 'fa fa-comment', \App\Entity\Commentaire::class);
        
        
        yield MenuItem::section('A propos', 'fa fa-ellipsis-v')->setCssClass('section');
        yield MenuItem::linkToUrl('EasyAdmin', 'fa fa-tools', 'https://github.com/EasyCorp/EasyAdminBundle')->setLinkTarget('_blank')->setLinkRel('noreferrer');
        
        yield MenuItem::section('')->setCssClass('section');
        yield MenuItem::linkToUrl('Retour Front', 'fa fa-backward', $this->generateUrl('homepage'))->setCssClass('synthese');
        
    }
}

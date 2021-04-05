<?php

namespace App\Controller\BackOffice;

use App\Entity\Page;
use App\Form\WebPageType;
use App\Repository\PageRepository;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

class PageController extends AbstractController
{
    /**
     * @var TagRepository
     */
    private $tagRepository;
    
    public function __construct(PageRepository $webpageRepository) {
        $this->webpageRepository = $webpageRepository;
    }

    
    /**
     * @Route("/backoffice/pages", name="back_office_pages")
     * @return Response
     */
    public function pages(): Response
    {
        return $this->render('back_office/tables.html.twig', [
            'entity' => WebPage::class,
            'list' => $this->webpageRepository->findAll()
        ]);
    }
    
    /**
     * @Route("/backoffice/page/new", name="back_office_page_new")
     * @return Response
     */
    public function new(Request $request): Response
    {
        $webpage = new WebPage();
        $form = $this->createForm(WebPageType::class, $webpage, []);
        $form->handleRequest($request);
        
        if ($request->isMethod('POST') && $form->isValid()) {
            $this->saveOrUpdate($webpage);
            $request->getSession()->getFlashBag()->add('notice', 'message.update.ok');
            return $this->redirectToRoute('back_office_pages');
        }
        
        return $this->render('back_office/webpage/form.html.twig', [
            'form' => $form->createView(),
        ]);
    }
    
    /**
     * @Route("/backoffice/page/edit/{id<\d+>}", name="back_office_page_edit")
     */
    public function edit(int $id, Request $request): Response 
    {
        $webpage = $this->webpageRepository->findOneBy(['id' => $id]);
        
        $form = $this->createForm(WebPageType::class, $webpage, []);
        $form->handleRequest($request);

        if ($request->isMethod('POST') && $form->isValid()) {
            $this->saveOrUpdate($webpage);
            $request->getSession()->getFlashBag()->add('notice', 'message.update.ok');
        }

        return $this->render('back_office/webpage/form.html.twig', [
            'form' => $form->createView(),
        ]);
    }
    
    /**
     * Methode pour créer ou modifier un article
     * @param WebPage $webpage
     * @throws \App\Controller\BackOffice\Exception
     */
    private function saveOrUpdate(WebPage $webpage)
    {
        /* @var $entityManager Doctrine\ORM\EntityManager */
        $entityManager = $this->getDoctrine()->getManager();

        try {
            $entityManager->getConnection()->beginTransaction();
            
            $entityManager->persist($webpage);
            $entityManager->flush();
            
            $entityManager->getConnection()->commit();
        } catch (Exception $e) {
            $entityManager->getConnection()->rollback();
            throw $e;
        }
    }
}

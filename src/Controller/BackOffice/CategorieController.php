<?php

namespace App\Controller\BackOffice;

use App\Entity\Categorie;
use App\Form\CategorieType;
use App\Repository\CategorieRepository;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

class CategorieController extends AbstractController
{
    /**
     * @var CategorieRepository
     */
    private $categorieRepository;
    
    public function __construct(CategorieRepository $categorieRepository) {
        $this->categorieRepository = $categorieRepository;
    }

    
    /**
     * @Route("/backoffice/categories", name="back_office_categories")
     * @return Response
     */
    public function categories(): Response
    {
        return $this->render('back_office/tables.html.twig', [
            'entity' => Categorie::class,
            'list' => $this->categorieRepository->findAll()
        ]);
    }
    
    /**
     * @Route("/backoffice/categories/new", name="back_office_categorie_new")
     * @return Response
     */
    public function new(Request $request): Response
    {
        $categorie = new Categorie();
        $form = $this->createForm(CategorieType::class, $categorie, []);
        $form->handleRequest($request);
        
        if ($request->isMethod('POST') && $form->isValid()) {
            $this->saveOrUpdate($categorie);
            $request->getSession()->getFlashBag()->add('notice', 'message.update.ok');
            return $this->redirectToRoute('back_office_tags');
        }
        
        return $this->render('back_office/categorie/form.html.twig', [
            'form' => $form->createView(),
        ]);
    }
    
    /**
     * @Route("/backoffice/categorie/edit/{id<\d+>}", name="back_office_categorie_edit")
     */
    public function edit(int $id, Request $request): Response 
    {
        $categorie = $this->categorieRepository->findOneBy(['id' => $id]);
        
        $form = $this->createForm(CategorieType::class, $categorie, []);
        $form->handleRequest($request);

        if ($request->isMethod('POST') && $form->isValid()) {
            $this->saveOrUpdate($categorie);
            $request->getSession()->getFlashBag()->add('notice', 'message.update.ok');
        }

        return $this->render('back_office/categorie/form.html.twig', [
            'form' => $form->createView(),
        ]);
    }
    
    /**
     * Methode pour créer ou modifier un article
     * @param Tag $tag
     * @throws \App\Controller\BackOffice\Exception
     */
    private function saveOrUpdate(Categorie $categorie)
    {
        /* @var $entityManager Doctrine\ORM\EntityManager */
        $entityManager = $this->getDoctrine()->getManager();

        try {
            $entityManager->getConnection()->beginTransaction();
            
            $entityManager->persist($categorie);
            $entityManager->flush();
            
            $entityManager->getConnection()->commit();
        } catch (Exception $e) {
            $entityManager->getConnection()->rollback();
            throw $e;
        }
    }
}

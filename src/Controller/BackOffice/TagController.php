<?php

namespace App\Controller\BackOffice;

use App\Entity\Tag;
use App\Form\TagType;
use App\Repository\TagRepository;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

class TagController extends AbstractController
{
    /**
     * @var TagRepository
     */
    private $tagRepository;
    
    public function __construct(TagRepository $tagRepository) {
        $this->tagRepository = $tagRepository;
    }

    
    /**
     * @Route("/backoffice/tags", name="back_office_tags")
     * @return Response
     */
    public function tags(): Response
    {
        return $this->render('back_office/tables.html.twig', [
            'entity' => Tag::class,
            'list' => $this->tagRepository->findAll()
        ]);
    }
    
    /**
     * @Route("/backoffice/tags/new", name="back_office_tag_new")
     * @return Response
     */
    public function new(Request $request): Response
    {
        $tag = new Tag();
        $form = $this->createForm(TagType::class, $tag, []);
        $form->handleRequest($request);
        
        if ($request->isMethod('POST') && $form->isValid()) {
            $this->saveOrUpdate($tag);
            $request->getSession()->getFlashBag()->add('notice', 'message.update.ok');
            return $this->redirectToRoute('back_office_tags');
        }
        
        return $this->render('back_office/tag/form.html.twig', [
            'form' => $form->createView(),
        ]);
    }
    
    /**
     * @Route("/backoffice/tag/edit/{id<\d+>}", name="back_office_tag_edit")
     */
    public function edit(int $id, Request $request): Response 
    {
        $tag = $this->tagRepository->findOneBy(['id' => $id]);
        
        $form = $this->createForm(TagType::class, $tag, []);
        $form->handleRequest($request);

        if ($request->isMethod('POST') && $form->isValid()) {
            $this->saveOrUpdate($post);
            $request->getSession()->getFlashBag()->add('notice', 'message.update.ok');
        }

        return $this->render('back_office/tag/form.html.twig', [
            'form' => $form->createView(),
        ]);
    }
    
    /**
     * Methode pour créer ou modifier un article
     * @param Tag $tag
     * @throws \App\Controller\BackOffice\Exception
     */
    private function saveOrUpdate(Tag $tag)
    {
        /* @var $entityManager Doctrine\ORM\EntityManager */
        $entityManager = $this->getDoctrine()->getManager();

        try {
            $entityManager->getConnection()->beginTransaction();
            
            $entityManager->persist($tag);
            $entityManager->flush();
            
            $entityManager->getConnection()->commit();
        } catch (Exception $e) {
            $entityManager->getConnection()->rollback();
            throw $e;
        }
    }
}

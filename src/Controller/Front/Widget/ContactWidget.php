<?php

namespace App\Controller\Front\Widget;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Twig\Environment;
use Doctrine\ORM\EntityManagerInterface;;

use App\Controller\Front\GenericController;
use App\Controller\WidgetInterface;

use App\Entity\Contact;
use App\Form\ContactType;

/**
 * Description of ContactWidget
 *
 * @author cedric
 * @Route("/contact", name="")
 */
class ContactWidget extends GenericController implements WidgetInterface 
{
    public function getName(): string 
    {
        return CategorieWidget::class;
    }
    
    public function getMethod(): string 
    {
        return 'show';
    }

    public function show(string $template = 'widgets/contact.html.twig') 
    {
        $contact = new Contact();
        $form = $this->createForm(ContactType::class, $contact, []);
        
        return $this->render($template,[
            'form' => $form->createView(),
        ]);
    }

    public function attributes(): array {
        return [];
    }
    
    /**
     * Affichage du formulaire Contact en mode Page pleine
     * 
     * @param Environment $engine
     * @param Request $request
     * @return Response
     * 
     * @Route("/formulaire", name="widget_contact_full_page_form")
     */
    public function fullPageContact(EntityManagerInterface $entityManager, Environment $engine, Request $request): Response
    {
        $template = '/widgets/contact/page.html.twig';
        if ($engine->getLoader()->exists($this->skin.$template)) {
            $template = $this->skin.$template;
        }
        
        $contact = new Contact();
        $form = $this->createForm(ContactType::class, $contact, []);
        $form->handleRequest($request);
        dump($contact);
        if ($request->isMethod('POST') && $form->isValid()) {
            try {
                $entityManager->getConnection()->beginTransaction();
                $entityManager->persist($contact);
                $entityManager->flush();
                $entityManager->getConnection()->commit();
                
                $this->sendMail([$contact->getEmail()], null, ['cedric.pujol@live.com'], $contact->getSujet(), $contact->getMessage());
            } catch (Exception $e) {
                $entityManager->getConnection()->rollback();
                throw $e;
            }
            $request->getSession()->getFlashBag()->add('notice', 'widget.contact.confirmation.validation.ok');
        }
        
        return $this->render($template, [
            'skin' => $this->skin,
            'form' => $this->createForm(ContactType::class, $contact, [])->createView(),
        ]);
    }

}

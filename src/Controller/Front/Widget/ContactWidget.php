<?php

namespace App\Controller\Front\Widget;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Yaml\Yaml;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Twig\Environment;
use Doctrine\ORM\EntityManagerInterface;

use App\Controller\WidgetInterface;
use App\Repository\ParametreRepository;
use App\Entity\Contact;
use App\Form\ContactType;

/**
 * Description of ContactWidget
 *
 * @author cedric
 * @Route("/contact", name="")
 */
class ContactWidget extends AbstractController implements WidgetInterface 
{
    /**
     * @param string $skin
     */
    private $skin;
    
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
     * @param EntityManagerInterface $entityManager
     * @param Environment $engine
     * @param Request $request
     * @param ParametreRepository $paramRepository
     * @return Response
     * 
     * @Route("/formulaire", name="widget_contact_full_page_form")
     */
    public function fullPageContact(EntityManagerInterface $entityManager, Environment $engine, Request $request, ParametreRepository $paramRepository): Response
    {
    	  $siteParams = Yaml::parseFile('../config/site.yaml');
		  $skinName = $siteParams['parameters']['app.params.skin'];
        $skin = $paramRepository->findOneBy(['cle' => $skinName])->getValeur();    	
    	
        $template = '/widgets/contact/page.html.twig';
        if ($engine->getLoader()->exists($this->skin.$template)) {
            $template = $skin.$template;
        }
        
        $contact = new Contact();
        $form = $this->createForm(ContactType::class, $contact, []);
        $form->handleRequest($request);

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
            'skin' => $skin,
            'form' => $this->createForm(ContactType::class, $contact, [])->createView(),
        ]);
    }

}

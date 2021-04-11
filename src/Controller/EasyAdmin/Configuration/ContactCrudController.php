<?php

namespace App\Controller\EasyAdmin\Configuration;

use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;

use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;

use App\Entity\Contact;

/**
 * Description of ContactCrudController
 *
 * @author cedric
 */
class ContactCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Contact::class;
    }

    /**
     * Gère les libellés
     * 
     * @param Crud $crud
     * @return Crud
     */
    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInPlural('Gestion des Contacts')
            ->setPaginatorPageSize(20)
            ->setDefaultSort(['id' => 'DESC'])
        ;
    }
    
    /**
     * Configure les filtres pour la recherche
     * 
     * @param Filters $filters
     * @return Filters
     */
    public function configureFilters(Filters $filters): Filters
    {
        return $filters
            ->add('nom')
            ->add('email')
            ->add('sujet')
        ;
    }
    
    /**
     * Configure les champs à afficher (Edition et Index)
     * 
     * @param string $pageName
     * @return iterable
     */
    public function configureFields(string $pageName): iterable
    {
        $id = IdField::new('id');

        $nom = TextField::new('nom');
        $email = TextField::new('email');
        $sujet = TextField::new('sujet');
        $message = TextareaField::new('message');

        if (Crud::PAGE_INDEX === $pageName) {
            return [$nom, $email, $sujet, $message];
        }
        
        return [
            $nom, $email, $sujet
        ];
    }
    
    /**
     * Paramètrage des actions de la page "Liste"
     * 
     * @param Actions $actions
     * @return Actions
     */
    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->update(Crud::PAGE_INDEX, Action::EDIT, function (Action $action) {
                return $action->setIcon('fa fa-pencil');
            })
            ->update(Crud::PAGE_INDEX, Action::DELETE, function (Action $action) {
                return $action->setIcon('fa fa-trash');
            })
            //->remove(Crud::PAGE_INDEX, Action::EDIT)
            //->remove(Crud::PAGE_INDEX, Action::NEW)
        ;
    }
}
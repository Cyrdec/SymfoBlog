<?php

namespace App\Controller\EasyAdmin\Configuration;

use App\Entity\Parametre;

use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;

use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;

/**
 * Gestion des tags du blog et des pages web 
 */
class ParametreCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Parametre::class;
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
            ->setEntityLabelInSingular('un nouveau Paramètre')
            ->setEntityLabelInPlural('Gestion des Paramétres')
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
            ->add('cle')
            ->add('valeur')
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

        $cle = TextField::new('cle');
        $valeur = TextField::new('valeur');

        return [
            $cle, $valeur
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

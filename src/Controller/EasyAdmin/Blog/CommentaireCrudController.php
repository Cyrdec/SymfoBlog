<?php

namespace App\Controller\EasyAdmin\Blog;

use App\Entity\Commentaire;

use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;

use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;

/**
 * Gestion des commentaires des articles
 * 
 */
class CommentaireCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Commentaire::class;
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
            ->setEntityLabelInPlural('Gestion des Commentaires')
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
            ->add('contenu')
            ->add('actif')
            ->add('pseudo')
            ->add('dateCreation')
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

        $contenu = TextareaField::new('contenu');
        $actif = BooleanField::new('actif');
        $email = EmailField::new('email');
        $pseudo = TextField::new('pseudo');
        $dateCreation = DateTimeField::new('dateCreation');
        $articles = AssociationField::new('articles');
        
        if (Crud::PAGE_INDEX === $pageName) {
            return [$pseudo, $dateCreation, $contenu, $actif];
        }

        return [
            $pseudo, $email, $contenu, $actif, $dateCreation, $articles
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
            ->remove(Crud::PAGE_INDEX, Action::NEW)
        ;
    }
}

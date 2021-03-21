<?php

namespace App\Controller\EasyAdmin\Blog;

use App\Entity\Article;

use FOS\CKEditorBundle\Form\Type\CKEditorType;

use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;

use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;

/**
 * Gestion des pages web du site
 * 
 */
class ArticleCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Article::class;
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
            ->addFormTheme('@FOSCKEditor/Form/ckeditor_widget.html.twig')
            ->setEntityLabelInSingular('une nouvelle Page')
            ->setEntityLabelInPlural('Gestion des Pages')
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
            ->add('titre')
            ->add('slug')
            ->add('contenu')
            ->add('dateCreation')
            ->add('dateModification')
            ->add('categories')
            ->add('tags')
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

        $titre = TextField::new('titre');
        $slug = TextField::new('slug');
        $intro = TextareaField::new('intro');
        $contenu = TextareaField::new('contenu')->setFormType(CKEditorType::class);
        $dateCreation = DateTimeField::new('dateCreation');
        $dateModification = DateTimeField::new('dateModification');
        $categories = AssociationField::new('categories');
        $tags = AssociationField::new('tags');
        $datePublication = DateTimeField::new('datePublication');
        $nbreLecture = NumberField::new('nbreLecture');
        $image = TextField::new('image');
        
        if (Crud::PAGE_INDEX === $pageName) {
            return [$titre, $slug, $intro, $tags, $nbreLecture];
        }

        return [
            $titre, $slug, $intro, $contenu, $categories, $tags, $datePublication, $image 
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

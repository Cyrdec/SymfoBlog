<?php

namespace App\Controller\EasyAdmin\Web;

use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;

use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;

use App\Entity\Image;

/**
 * Description of ImageCrudController
 *
 * @author cedric
 */
class ImageCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Image::class;
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
            ->setEntityLabelInSingular('une nouvelle Image')
            ->setEntityLabelInPlural('Gestion des Images')
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
        $type = \EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField::new('type')
                ->setChoices([
                    'Edito'=>'public/uploads/edito',
                    'Standard'=>'public/uploads',
                ]);
        $image = ImageField::new('url')
                ->setUploadedFileNamePattern('[randomhash].[extension]')
                ->setUploadDir('public/uploads');
        
        if (Crud::PAGE_INDEX === $pageName) {
            return [$titre, $type, $image->setBasePath('uploads')];
        }

        return [
            $titre, $type, $image
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
<?php

namespace App\Controller\EasyAdmin\Web;

use App\Entity\Edito;

use FOS\CKEditorBundle\Form\Type\CKEditorType;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;

class EditoCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Edito::class;
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
            ->setEntityLabelInSingular('un nouvel Edito')
            ->setEntityLabelInPlural('Gestion des Edito')
            ->setPaginatorPageSize(20)
            ->setDefaultSort(['id' => 'DESC'])
        ;
    }

    
    public function configureFields(string $pageName): iterable
    {
        $id = IdField::new('id');

        $titre = TextField::new('titre');
        $slug = TextField::new('slug');
        $contenu = TextareaField::new('contenu')->setFormType(CKEditorType::class);
        $datePublication = DateTimeField::new('datePublication')->setFormat('dd/MM/yy HH:mm:ss');
        
        if (Crud::PAGE_INDEX === $pageName) {
            return [$id, $titre, $slug, $datePublication];
        }
        
        return [
            $titre, $slug, $contenu, $datePublication
        ];
    }
    
}

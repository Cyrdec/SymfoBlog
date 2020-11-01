<?php

namespace App\Form;

use App\Entity\Article;
use App\Entity\Categorie;
use App\Entity\Tag;
use App\Repository\CategorieRepository;
use App\Repository\TagRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ArticleType extends AbstractType
{
    /**
     * @var array 
     */
    private $categories;
    
    public function __construct(CategorieRepository $categorieRepository)
    {
        $this->categories = $categorieRepository->findAll();
    }
    
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('titre', TextType::class, [
                'attr' => ['maxlength' => 100],
                'required' => true
            ])
            ->add('slug', TextType::class, [
                'attr' => ['maxlength' => 255],
                'required' => true
            ])
            ->add('contenu', CKEditorType::class, [
                'required' => true
            ])
            ->add('categories', EntityType::class, [
                'class'        => 'App\Entity\Categorie',
                'choice_label' => 'slug',
                'query_builder' => function (CategorieRepository $repo) {
                    return $repo->createQueryBuilder('c')
                        ->where('c.id >= :id')
                        ->setParameter('id', 1);
                },
                'expanded'     => true,
                'multiple'     => true,
            ])
            ->add('tags', EntityType::class, [
                'class'        => 'App\Entity\Tag',
                'choice_label' => 'slug',
                'query_builder' => function (TagRepository $repo) {
                    return $repo->createQueryBuilder('t')
                        ->where('t.id >= :id')
                        ->setParameter('id', 1);
                },
                'expanded'     => true,
                'multiple'     => true,
            ])
            ->add('save', SubmitType::class, [
                'label' => 'button.search'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Article::class,
        ]);
    }
}

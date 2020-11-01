<?php

namespace App\Form;

use App\Entity\WebPage;
use App\Repository\TagRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class WebPageType extends AbstractType
{
    
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom', TextType::class, [
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
            'data_class' => WebPage::class,
        ]);
    }
}

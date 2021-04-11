<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

use App\Entity\Contact;
use App\Entity\Parametre;
use App\Repository\ParametreRepository;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        
        $builder
            ->add('nom', TextType::class, [
                
            ])
            ->add('email', TextType::class, [
                
            ])
            ->add('sujet', ChoiceType::class, [
                'choices'=> $this->sujets(),
                'required' => false
            ])
            ->add('message', TextareaType::class, [
                
            ])
            ->add('validate', SubmitType::class, [
                'label' => 'widget.contact.button.validate'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Contact::class,
        ]);
    }
    
    /**
     * @var ParametreRepository 
     */
    private $parametreRepository;
    
    public function __construct(ParametreRepository $parametreRepository) {
        $this->parametreRepository = $parametreRepository;
    }
    
    /**
     * Récupère la liste des sujets paramétrés
     * @return type
     */
    private function sujets() {
        $sujets = $this->parametreRepository->createQueryBuilder('c')
                        ->where('c.cle LIKE :cle')
                        ->setParameter('cle', 'FORM_CTC%')->getQuery()->getResult();
        $values = [];
        foreach($sujets as $s) {
            $values = array_merge($values, [$s->getValeur() => $s->getValeur()]);
        }
        return $values;
    }
    
}

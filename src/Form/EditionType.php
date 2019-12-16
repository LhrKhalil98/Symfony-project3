<?php

namespace App\Form;

use App\Entity\Edition;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EditionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('num_edition')
            ->add('date_sortie')
            ->add('prix')
            ->add('quantite')
            ->add('article',  EntityType::class , [
                'placeholder' => 'Article ',
                'class' => 'App\Entity\Article',
                'choice_label' => 'titre'
            ])
            ->add('Ajouter', SubmitType::class, [
                'attr' => ['class' => 'save'] ] )
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Edition::class,
        ]);
    }
}

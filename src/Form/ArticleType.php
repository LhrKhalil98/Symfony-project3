<?php

namespace App\Form;

use App\Entity\Article;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ArticleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('titre')
            ->add('image' , FileType::class ,[
                'label'=>'Choisissez une image', 
                'attr' => ['class' => 'form-control'] 
            ])
            ->add('langue' ,  EntityType::class , [
                'placeholder' => 'Langue ',
                'class' => 'App\Entity\Langue',
                'choice_label' => 'langue' , 
                'attr' => ['class' => 'form-control']
            ]) 
            ->add('theme',  EntityType::class , [
                'placeholder' => 'Theme ',
                'class' => 'App\Entity\Theme',
                'choice_label' => 'theme' ,
                'attr' => ['class' => 'form-control']
            ])
            ->add('auteur',  EntityType::class , [
                'placeholder' => 'Auteur ',
                'class' => 'App\Entity\Auteur',
                'choice_label' => 'auteur' ,
                'attr' => ['class' => 'form-control']
            ])
            ->add('type',  EntityType::class , [
                'placeholder' => 'Type ',
                'class' => 'App\Entity\Type',
                'choice_label' => 'type' , 
                'attr' => ['class' => 'form-control']
            ])
            ->add('Ajouter', SubmitType::class, [
                'attr' => ['class' => 'save']
                 ] )
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Article::class,
        ]);
    }
}

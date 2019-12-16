<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ClientType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            
            ->add('nom' , TextType::class ,[
                'attr' => ['class' => 'form-control']
            ])
            ->add('prenom', TextType::class ,[
                'attr' => ['class' => 'form-control']
            ])
            ->add('email'  ,EmailType::class ,[
                'attr' => ['class' => 'form-control']
            ])
            ->add('password' , PasswordType::class,[
                'attr' => ['class' => 'form-control']
            ])
            ->add('confirm_password', PasswordType::class,[
                'attr' => ['class' => 'form-control']
            ])
            ->add('adress', TextType::class ,[
                'attr' => ['class' => 'form-control']
            ])
            ->add('num_tel', TextType::class ,[
                'attr' => ['class' => 'form-control']
            ])
            ->add('Create', SubmitType::class, [
                'attr' => ['class' => 'btn_3'] ] )
                
            ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}

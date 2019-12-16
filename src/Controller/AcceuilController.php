<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;

class AcceuilController extends AbstractController
{
    /**
     * @Route("/", name="app_acceuil")
     */
    public function index()
    {
        return $this->render('acceuil/index.html.twig', [
            'controller_name' => 'AcceuilController',
        ]);
    }

    /**
     * @Route("/about", name="app_about")
     */
    public function about ()
    {
        return $this->render('acceuil/about.html.twig', [
            'controller_name' => 'AcceuilController',
        ]);
    }

    /**
     * @Route("/contact", name="app_contact")
     */
    public function contact (Request $request  , MailerInterface $mailer)
    {
        $form = $this->createFormBuilder( )
                    ->add('message', TextareaType::class, array('attr' => array('class' => 'form-control' , 'cols'=>'30' , 'rows'=>'9'
                    , 'onfocus'=>"this.placeholder = ''" , 'onblur'=>"this.placeholder = 'Enter Message'",
                    'placeholder'=>'Enter Message')))
                    ->add('name' , TextType::class ,['attr' => ['class' => 'form-control' ,'placeholder'=>'Enter your name ' ] ])
                    ->add('address', EmailType::class ,['attr' => ['class' => 'form-control' ,'placeholder'=>'Enter your email ' ] ])
                    ->add('subject', TextType::class,['attr' => ['class' => 'form-control' ,'placeholder'=>'Enter subject  ' ] ] )
                    ->getForm();
        $form->handleRequest($request); 
        if($form->isSubmitted()&& $form->isValid())
        {
            $email = (new Email()) 
                   ->from($form->get('address')->getData())
                   ->to('lhrkhalil@gmail.com')
                   ->subject($form->get('subject')->getData())
                   ->text($form->get('message')->getData());
            $mailer->send($email);
            return $this->redirectToRoute('app_acceuil');
        }
        return $this->render('acceuil/contact.html.twig', [
            'form'=>$form->createView() , 
        ]);
    }
}

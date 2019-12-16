<?php

namespace App\Controller;

use App\Entity\User;

use App\Form\ClientType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

class SecuriteController extends AbstractController
{
   /**
     * @Route("/inscription", name="app_inscription")
     */
    public function Inscription(Request $request , MailerInterface $mailer , UserPasswordEncoderInterface $encoder )
    {
        if ($this->getUser()) {
            return $this->redirectToRoute('app_acceuil');
        }
       
        $manager = $this->getDoctrine()->getManager();
        $client= new User() ; 

        $form = $this -> createForm(ClientType::class , $client) ;
        $form->handleRequest($request); 
        if($form->isSubmitted()&& $form->isValid())
        {
            $hash = $encoder->encodePassword( $client,$client->getPassword());
            $client->setPassword($hash);
            $client->setRoles(array('ROLE_USER'));
            $manager->persist($client); 
            $manager->flush();
            $email = (new Email()) 
                    ->from('lhrkhalil98@gmail.com')
                    ->to($client->getEmail())
                    ->subject('Bienvenue chez Nous')
                    ->text(" Nice To meet you   {$client->getNom()}! ❤️");
            $mailer->send($email);
            return $this->redirectToRoute('app_login');

        }
        return $this->render('user/create.html.twig', [
            'controller_name' => 'ContractController',
            'form' => $form->createView() ,
        ]);
    }

    /**
     * @Route("/login", name="app_login")
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        if ($this->getUser()) {
            return $this->redirectToRoute('app_acceuil');
        }

        $error = $authenticationUtils->getLastAuthenticationError();
        
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('securite/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    /**
     * @Route("/logout", name="app_logout")
     */
    public function logout()
    {
    
    }
      /**
     * @Route("/admin/ajouter", name="app_nouveau_admin")
     */
    public function ajouterAdmin(Request $request  , UserPasswordEncoderInterface $encoder )
    {
       
       
        $manager = $this->getDoctrine()->getManager();
        $admin= new User() ; 

        $form = $this->createFormBuilder($admin)
                     ->add('email', EmailType::class, array('attr' => array('class' => 'form-control')))
                     ->add('password' , PasswordType::class)
                     ->add('confirm_password', PasswordType::class)
                     ->add('ajouter', SubmitType::class, [
                        'attr' => ['class' => 'save'] ] )
                     ->getForm();
        $form->handleRequest($request); 
        if($form->isSubmitted()&& $form->isValid())
        {
            $hash = $encoder->encodePassword( $admin,$admin->getPassword());
            $admin->setPassword($hash);
            $admin->setRoles(array('ROLE_ADMIN'));
            $manager->persist($admin); 
            $manager->flush();
            return $this->redirectToRoute('app_acceuil');

        }
        return $this->render('User/index.html.twig', [
            'controller_name' => 'ContractController',
            'form' => $form->createView() ,
        ]);
    }
    
}

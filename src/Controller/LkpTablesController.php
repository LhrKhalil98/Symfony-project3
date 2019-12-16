<?php

namespace App\Controller;

use App\Entity\Langue;
use App\Entity\Theme;
use App\Entity\Type;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

class LkpTablesController extends AbstractController
{
    /**
     * @Route("/lkp/langues/ajouter", name="app_ajouter_langue")
     * @IsGranted("ROLE_ADMIN")
     */
    public function ajouterLangue(Request $request)
    {
        $manager = $this->getDoctrine()->getManager();

        $langue =new Langue();
        $form = $this->createFormBuilder($langue)
                     ->add('langue', TextType::class, array('attr' => array('class' => 'form-control')))
                     ->add('ajouter', SubmitType::class, [
                        'attr' => ['class' => 'save'] ] )
                     ->getForm();
        $form->handleRequest($request); 
        if($form->isSubmitted()&& $form->isValid()){
            $manager->persist($langue) ; 
            $manager->flush(); 
            return $this->redirectToRoute('app_acceuil');
        }

        return $this->render('lkp_tables/index.html.twig', [
            'form'=>$form->createView() , 
        ]);
      
    }
    /**
     * @Route("/lkp/themes/ajouter", name="app_ajouter_theme")
     * @IsGranted("ROLE_ADMIN")
     */
    public function ajouterTheme(Request $request)
    {
        $manager = $this->getDoctrine()->getManager();

        $theme =new Theme();
        $form = $this->createFormBuilder($theme)
                     ->add('theme', TextType::class, array('attr' => array('class' => 'form-control')))
                     ->add('ajouter', SubmitType::class, [
                        'attr' => ['class' => 'save'] ] )
                     ->getForm();
        $form->handleRequest($request); 
        if($form->isSubmitted()&& $form->isValid()){
            $manager->persist($theme) ; 
            $manager->flush(); 
            return $this->redirectToRoute('app_acceuil');
        }

        return $this->render('lkp_tables/index.html.twig', [
            'form'=>$form->createView() , 
        ]);
      
    }
      /**
     * @Route("/lkp/types/ajouter", name="app_ajouter_type")
     * @IsGranted("ROLE_ADMIN")
     */
    public function ajouterType(Request $request)
    {
        $manager = $this->getDoctrine()->getManager();

        $type =new Type();
        $form = $this->createFormBuilder($type)
                     ->add('type', TextType::class, array('attr' => array('class' => 'form-control')))
                     ->add('ajouter', SubmitType::class, [
                        'attr' => ['class' => 'save'] ] )
                     ->getForm();
        $form->handleRequest($request); 
        if($form->isSubmitted()&& $form->isValid()){
            $manager->persist($type) ; 
            $manager->flush(); 
            return $this->redirectToRoute('app_acceuil');
        }

        return $this->render('lkp_tables/index.html.twig', [
            'form'=>$form->createView() , 
        ]);
      
    }
}

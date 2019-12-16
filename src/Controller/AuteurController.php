<?php

namespace App\Controller;

use App\Entity\Auteur;
use App\Form\AuteurType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

class AuteurController extends AbstractController

{
/**
     * @Route("/auteurs/ajouter", name="app_ajouter_auteur")
     * @IsGranted("ROLE_ADMIN")
     */
    public function ajouterAuteur(Request $request   )
    {
        $manager = $this->getDoctrine()->getManager();
        $auteur= new Auteur() ; 
        $form = $this -> createForm(AuteurType::class , $auteur) ;
        $form->handleRequest($request); 
        if($form->isSubmitted()&& $form->isValid())
        {
            $manager->persist($auteur); 
            $manager->flush();
            return $this->redirectToRoute('app_acceuil');
        }
        return $this->render('lkp_tables/index.html.twig', [
            'controller_name' => 'ContractController',
            'form' => $form->createView() ,
        ]);
    }
}

<?php

namespace App\Controller;

use App\Entity\Commande;
use App\Entity\Edition;
use App\Entity\LigneCommande;
use App\Repository\CommandeRepository;
use App\Repository\EditionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

class PanierController extends AbstractController
{
    /**
     * @Route("/panier/ajouter/{id_edition}", name="app_panier_ajouter")
     */
    public function ajouterPanier($id_edition , SessionInterface $session)
    {
        $panier = $session->get('panier' , []) ; 
        if(empty($panier[$id_edition]))
            $panier[$id_edition]=1; 
        else
            $panier[$id_edition]++; 
        $session ->set('panier' , $panier) ;
        return $this->redirectToRoute("app_afficher_panier") ; 


    }
    /**
     * @Route("/panier/supprimer/{id_edition}", name="app_panier_supprimer")
     */
    public function supprimerPanier($id_edition , SessionInterface $session)
    {
        $panier = $session->get('panier' , []) ; 
        if(!empty($panier[$id_edition]))
            unset($panier[$id_edition]) ; 
     
        $session ->set('panier' , $panier) ; 
        return $this->redirectToRoute("app_afficher_panier") ; 

    }
    /**
     * @Route("/panier/afficher", name="app_afficher_panier")
     */
    public function afficherPanier( EditionRepository $edition_repo  ,  SessionInterface $session )
    { 
        $panier = $session->get('panier', []); 
        $achats = [] ; 
        foreach($panier as $id_edition => $quantite ){
            $achats[]= [
                'edition'=> $edition_repo->find($id_edition), 
                'quantite'=> $quantite , 
            ];

        }
        $total = 0 ; 
        foreach($achats as $achat ){
           $total += $achat['edition']->getPrix() * $achat['quantite']; 
        }

        return $this->render('panier/panier.html.twig', [
            'controller_name' => 'PanierController',
            'achats'=> $achats ,
            'total' => $total , 
        ]);
    }
      
    /**
     * @Route("/panier/confirmer", name="app_confirmer_panier")
     * 
     */
    public function confirmerPanier( EditionRepository $edition_repo  ,  SessionInterface $session) 
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $manager = $this->getDoctrine()->getManager();
         
        $panier = $session->get('panier', []); 
        $commande =new Commande();
        $commande->setClient($this->getUser()) ; 
        $commande->setConfirmer(false) ;
        $commande-> setDateCommande(new \DateTime()) ;
        $manager->persist($commande) ; 
        $manager->flush(); 
        foreach($panier as $id_edition => $quantite ){
            
            $ligneCommande = new LigneCommande() ; 
            $ligneCommande->setQuantite($quantite) ;
            $edition=  $edition_repo->find($id_edition) ; 
            $ligneCommande->setEdition($edition) ; 
            $edition->setQuantite($edition->getQuantite()-$quantite); 

            $ligneCommande->setCommande($commande) ;
            $manager->persist($ligneCommande) ; 
            $manager->flush(); 
         
           

        }
        $session->remove('panier'); 
        
        return $this->redirectToRoute("app_acceuil") ; 


    }


    /**
     * @Route("/admin/commandes", name="admin_commande")
     * @IsGranted("ROLE_ADMIN")
     */
    public function allCommande( CommandeRepository $commandes ) 
    {
         
        return $this->render('commandes/index.html.twig', [
           'commandes' => $commandes->findAll()
        ]); 
    }
}

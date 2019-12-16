<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\AdminType;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

class AdminController extends AbstractController
{
    /**
     * @Route("/admin", name="admin")
     *  @IsGranted("ROLE_ADMIN")

     */
    public function index( UserRepository $users)
    {
        return $this->render('admin/index.html.twig', [
            'controller_name' => 'AdminController',
            'users' => $users->findAll(),
        ]);
    }
        /**
     * @Route("/admin/ajouter", name="new_admin")
     * @IsGranted("ROLE_ADMIN")
     */
    public function newAdmin(Request $request ,  UserPasswordEncoderInterface $encoder )

    { 

        $client = new User();
        $form = $this->createForm(AdminType::class, $client);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $hash = $encoder->encodePassword( $client,$client->getPassword());
            $client->setPassword($hash);
            $client->setRoles(array('ROLE_ADMIN'));
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($client);
            $entityManager->flush();

            return $this->redirectToRoute('admin');
        }

        return $this->render('admin/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}

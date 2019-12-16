<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Edition;
use App\Entity\Langue;
use App\Entity\Theme;
use App\Entity\Type;
use App\Form\ArticleType;
use App\Form\EditionType;
use App\Repository\ArticleRepository;
use App\Repository\EditionRepository;
use App\Repository\LangueRepository;
use App\Repository\ThemeRepository;
use App\Repository\TypeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;


class ArticleController extends AbstractController
{
    /**
     * @Route("/articles/ajouter", name="app_ajouter_article")
     *         @IsGranted("ROLE_ADMIN")

     * 
     */
    public function ajouterArticle(Request $request   )
    {
        $manager = $this->getDoctrine()->getManager();
        $article = new Article() ; 
        $form = $this -> createForm(ArticleType::class , $article) ;
        $form->handleRequest($request); 
        if($form->isSubmitted()&& $form->isValid())
        {
            $image =$form->get('image')->getData(); 
            $nomImage = md5(uniqid()).'.'.$image->guessExtension() ;
            $image->move($this->getParameter('upload_directory'),$nomImage) ; 
            $article->setImage($nomImage) ; 
            $manager->persist($article); 
            $manager->flush();
            return $this->redirectToRoute('app_acceuil');
        }
        return $this->render('article/new.html.twig', [
            'controller_name' => 'ContractController',
            'form' => $form->createView() ,
        ]);
    }
    
    /**
     * @Route("/admin/articles", name="articles")
     *      *         @IsGranted("ROLE_ADMIN")

     */
    public function Articles(ArticleRepository $article_repo  ) 
    {
        $articles=$article_repo->findAll(); 
        return $this->render('article/articles.html.twig', [
            'articles'=>$articles , 
         
        ]); 
    }
    /**
     * @Route("/articles", name="app_tout_article")
     * 
     */
    public function afficherToutArticles(ArticleRepository $article_repo , ThemeRepository $themes ,TypeRepository $types , LangueRepository $langues ) 
    {
        $articles=$article_repo->findAll(); 
        return $this->render('article/index.html.twig', [
            'articles'=>$articles , 
            'themes'=>$themes->findAll(), 
            'langues'=>$langues->findAll(), 
             'types'=>$types->findAll(), 
        ]); 
    }
     /**
     * @Route("/articles_theme/{id}", name="article_theme")
     * 
     */
    public function findbyTheme( Theme $theme, ThemeRepository $themes ,TypeRepository $types , LangueRepository $langues ) 
    {

        $articles = $theme->getArticles() ; 
        return $this->render('article/index.html.twig', [
            'articles'=>$articles , 
            'themes'=>$themes->findAll(), 
            'langues'=>$langues->findAll(), 
             'types'=>$types->findAll(), 
        ]); 
    }
        /**
     * @Route("/articles_type/{id}", name="article_type")
     * 
     */
    public function findbyType( Type $theme, ThemeRepository $themes ,TypeRepository $types , LangueRepository $langues ) 
    {

        $articles = $theme->getArticles() ; 
        return $this->render('article/index.html.twig', [
            'articles'=>$articles , 
            'themes'=>$themes->findAll(), 
            'langues'=>$langues->findAll(), 
             'types'=>$types->findAll(), 
        ]); 
    }
        /**
     * @Route("/articles_langue/{id}", name="article_langue")
     * 
     */
    public function findbyLangue( Langue $theme, ThemeRepository $themes ,TypeRepository $types , LangueRepository $langues ) 
    {

        $articles = $theme->getArticles() ; 
        return $this->render('article/index.html.twig', [
            'articles'=>$articles , 
            'themes'=>$themes->findAll(), 
            'langues'=>$langues->findAll(), 
             'types'=>$types->findAll(), 
        ]); 
    }
    /**
     * @Route("/articles/{id}", name="app_article")
     */
    public function afficherArticle(ArticleRepository $article_repo , $id ,EditionRepository $edition_repo ) 
    {
        $article=$article_repo->find($id); 
        $editions=$edition_repo ->findBy(['article' =>$id ], );
        return $this->render('article/article.html.twig', [
            'article'=>$article , 
            'editions'=>$editions
        ]); 
    }
    /**
     * @Route("/articles_edition/ajouter", name="app_ajouter_edition")
     * @IsGranted("ROLE_ADMIN")
     */
    public function ajouterType(Request $request)
    {
        $manager = $this->getDoctrine()->getManager();

        $edition =new Edition();
        $form = $this -> createForm(EditionType::class , $edition) ;

        $form->handleRequest($request); 
        if($form->isSubmitted()&& $form->isValid()){
            $manager->persist($edition) ; 
            $manager->flush(); 
            return $this->redirectToRoute('app_acceuil');
        }

        return $this->render('lkp_tables/index.html.twig', [
            'form'=>$form->createView() , 
        ]);
    }

 
}

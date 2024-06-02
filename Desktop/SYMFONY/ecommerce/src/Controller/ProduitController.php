<?php

namespace App\Controller;

use App\Entity\Produit;
use App\Form\ProduitType;
use Doctrine\ORM\EntityManager;
use App\Repository\ProduitRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**@route("/produit")*/

class ProduitController extends AbstractController
{
    // Ce Controller va contenir toutes les routes du CRUD Produit


    /**
     * Cette route va récupérer ts les produits (=> REQUETE SQL SELECT)
     * 
     * @Route("/produit/afficher", name="produit_afficher")
    */
    public function produit_afficher(ProduitRepository $produitRepository): Response
    {
        /**Lorsqu'on crée une entity (=table), est générée en même temps que  son Repository, 
         * celui-ci permet de faire des requêtes dans cette table.
         * 
         * La fonction produit_afficher() a besoin d'un objet de la class ProduitRepository c'est dc une DEPENDANCE. L'objet instancié ici est $produitRepository.
         * 
         * Pour créer des dépendances, on les écrit ds les parenthèses de la fonction de la façon suivante : (Class $objet), il n'y a pas de , SAUF  si je veux ajouter une autre dépendance.
         * La class ici c'est ProduitRepository
         * l'objet ici c'est $produitRepository
         */

        $produits = $produitRepository->findAll(); // SELECT *FROM produit
        //la méthode findAll retourne un tableau d'objets.

        //dd($produits); pour vérifier le contenu de ma variable.

        return $this->render('produit/produit_afficher.html.twig', ['produits'=> $produits
            
        ]);
    }

    /**
     * La route produit ajouter permet de créer des produits en base de données on utilise un formulaire. 
     * 
     * @Route("/produit/ajouter", name="produit_ajouter")
    */
    public function produit_ajouter(Request $request, EntityManagerInterface $em): Response
    {
        // on instance la class (Entity) Produit
        $produit = new Produit();
        dump($produit);
        //$produit->setTitre('bague en or')
        //dd($produit);

        /** Pour créer un formulaire, on utlise  la méthode createForm()
         * provenant la class AbstractController
         * 1er argument : le nom de la class contenant le $builder
         * 2 ème argument : l'objet issu de la class (Entity) Produit
         * 
         * La class ProduitType et l'objet $produit st ts les 2 issusde la classe (Entity) Produit
         * **/

        $form = $this->createForm(ProduitType::class, $produit);
         //$form est un objet, il contient des propriétés et des méthodes

         //Traitement  du formulaire
        $form->handleRequest($request);

        //si le formulaire est soumis et s'il est valide cad qu'il respect toutes les contraintes ALORS
        if ($form->isSubmitted() && $form->isValid()) {
            //insertion en bdd
            dump($produit);
            /**Pour insérer, modifier ou supprimeren base de données, on utilise une class EntityManagerInterface */

            $em->persist($produit);
            $em->flush();
            //dd($produit);
            //la méthode redirectToRoute('') permet de
            return $this->redirectToRoute('produit_afficher');


        }
        

        return $this->render('produit/produit_ajouter.html.twig',['formProduit' => $form->createView() //création du formulaire HTML
    ]);
    }

    /**
    * 
    *  @Route("/produit/fiche/{id}",name="produit_fiche")
    */

    public function produit_fiche(Produit $produit) :Response
    {
        //dump($produit);
        return $this->render('produit/produit_fiche.html.twig',[
            'produit' => $produit
        ]);
    
    }

     /**
    * 
    *  @Route("/produit/modifier/{id}",name="produit_modifier")
    */

    public function produit_modifier(Produit $produit, Request $request, EntityManagerInterface $em) :Response
    {
        /** On constate  que pour ajouter et modifier un produit,
         * c'est le même code à l'exception de l'objet $produit
         * pour ajouter, on génère un nvel objet pour modifier, on récupère un objet en bdd grace au paramètre
        */
       
        $form = $this->createForm(ProduitType::class, $produit);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() AND $form->isValid()){
            $em->flush();
             return $this->redirectToRoute('produit_afficher');
        }
            return $this->render('produit/produit_modifier.html.twig',[
            'produit' => $produit,
            'formProduit' => $form->createView()
        ]);
        
            
    }   

 /**
    * 
    *  @Route("/produit/supprimer/{id}",name="produit_supprimer")
    */

    public function produit_supprimer(Produit $produit, EntityManagerInterface $em) 
    {
        /** Cette fonction ne renvoie pas de vue, dc on n'utilise pas la méthode render, on utilise $em->remove()
        */
       
        
            $em->remove($produit);
            $em->flush();
            return $this->redirectToRoute('produit_afficher');
    }
            
            
    









}
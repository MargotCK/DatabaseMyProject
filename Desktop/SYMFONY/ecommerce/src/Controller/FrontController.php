<?php

namespace App\Controller; // App = src App\Controller c'est le chemin où se trouve le namespace, 
//le namespace App\Contoller est dans le dossier "src"( qui est appelé "App" par Autoload) à l'intérieur de Controller.

// ! \\ ATTENTION PENSEZ TJS A IMPORTER LES CLASSES UTILISEES

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\Loader\Configurator\twig;


class FrontController extends AbstractController // héritage de AbstractController
{
    /**
     * ici : commentaire
     * 
     * Les annotations s'écrivent dans des commentaires
     * Les annotations commençent par un arobase pour être interprêtées 
     * Les annotations utilisent des doubles quotes ("") et le signe égal (=)
     * Il y a 2 arguments obligatoires : 
     * 1e : Route (URL)
     *      en local: 127.0.0.1:8000 /route
     *      en ligne: www.nomdedomaine.fr /route
     * 2e : Nom de la route (lien/redirection)
     * 
     * @Route("/front", name="frontName")
     * 
     * Les attributs ne s'écrivent pas dans des commentaires
     * Les attributs utilisent des simples quotes ('') et le signe deux points (:)
     * 
     * #[Route('/front', name:'frontName')]
     * Uniquement pour PHP8 / SF6
     */

    public function index(): Response
    {
        /* 
            La route appelle la fonction qui se trouve en dessous

            Une route peut avoir une vue (c-à-d : un fichier visible sur le navigateur soit HTML)

            Pour retourner une view, on utilise la méthode render() provenant de la class AbstractController

            Cette méthode a 2 arguments :
                -1e obligatoire : (str) c'est le nom du fichier html.twig situé dans le dossier, il faut également 
                définir son arborescence dans ce dossier (la méthode render() nous positionne directement à la racine du dossier 'templates')

                -2e facultatif : (array) : c'est le tableau des données à  véhiculer à la view.
        */
        return $this->render('front/index.html.twig',[]);
        
    }
   
    /**
     * 
     * Exercice :
     * 
     * Créer dans FrontController une nouvelle route
     * 
     * 1- créer la route (annotation)
     * les 2 arguments de la route sont 
     *              ->/home
     *              ->homeName
     * 
     * 2-Créer la fonction associée à cette route 
     *              -> la function home()
     * 
     * 3- Créer un template ds le dosier front que vs allez appeler 
     *              -> home.html.twig
     * 
     * 4-retourner ce template dans la fonction home()
     * 
     * ===> aller voir  si vous avez une page blanchebsur la navigateur 127.0.0.1:8000/home 
     * 
     * 
     * 5- Ds le template 
     *          -héritez de la base.html.twig
     *          -intégrez le block h1: Page d'accueil
     *          -intégrez le block body ds lequel vs allez afficher l'image
     */

/** LA PAGE PRINCIPALE D'UN SITE
 * @Route("", name="homeName")
 * 
 * #[Route('',name:'')]
 * */ 

    public function home(): Response
    {
        $prenomController = 'Lola';
        dump($prenomController); //  Sur Symfony"dump" permet de visualiser le contenu des variables, des tableaux et des objets.

        $array = ["kiwi", "pomme"];
        //dump($array);die; => die permet d'arrêter la lecture du code.
        //dd('fin'); // dd() = dump die

        return $this->render('front/home.html.twig',
        [
            // key => value
            // key : nom de la variable en twig = débomination récupérée en twig
            // value : nom de la variable php = dénomination ds la fonction du controller
            
            'prenomTwig' => $prenomController

        ]);// FERMETURE DU TABLEAU
    }// FERMETURE DE LA FONCTION


} // FERMETURE DE LA CLASS



    


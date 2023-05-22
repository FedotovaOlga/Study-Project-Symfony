<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TestController extends AbstractController // héritage
{
    /*
    Une route est un lien entre une URL et une méthode d'un contrôleur.
    Lorsque l'on essaiera d'accéder à cette URL, c'est cette méthode qui sera exécutée.
    Pour définir une route, on utilise les attributs (PHP 8) qui sont des commentaires, qui permettent de définir des méta-données. Ces attributs commencent toujours par un #[et se terminent par]
    */
    #[Route('/test', name: 'app_test')]
    public function index(): Response // ça veut dire que la méthode index() renvoit un objet de la classe Response importée plus haut avec "use" (donc la class TestControlleur contient une méthode qui renvoit un objet d'une autre class)
    {
        return $this->render('test/index.html.twig', [
            'controller_name' => 'everybody',
        ]);
    }

    #[Route('/affiche', name:"app_test_affiche")] // maintenant à la place de /affiche et /test(plus haut) on peut mettre tout ce qu'on veut, faut juste rafraichir la page, en étant sur une autre page, pour que ça recréé les liens
    public function affiche()
    {
        return $this->render("base.html.twig");
    }
    /* exo : ajouter une nouvelle route pour le chemin "/salut" qui affiche
        Bonjour le monde
    juste après la balise h1 du fichier base.html.twig. Pour cet affichage, créer un nouveau fichier twig (dans le dossier 'test') 
    */

    /*
    Si on veut qu'une partie du chemin soit variable, on peut définir un paramètre dans la route. Il suffit de mettre le paramètre entre {} dans le chemin.
    Ensuite il faut récupérer la valeur de ce paramètre en le passant dans les arguments de la méthode ($prenom).
    */
    #[Route('/salut/{prenom}')] // {prenom} est un paramètre, c'est une variable
    public function salut($prenom)
    {
        // exo : cette page doit afficher "bonjour" suivi de la valeur de $prenom
        // $prenom = "Jess"; // on a mis ça en commentaire, parce que mainteant on peut écrire le prénom directement dans URL
        return $this->render("test/salut.html.twig", [
            "prenom" => $prenom // "prenom" c'est la variable qu'on a mis dans le fichier Twig (salut), entre {{}}. Alors que $prenom c'est la valeur de la variable déclarée plus haut ("Gérard"), puis passée en paramètres de public function salut().
        ]);
    }

    /* EXO : modifier cette route pour que la valeur de a soit récupérée dans l'URL */
    #[Route("/test/conditions/{parametre}",requirements: ["parametre" => "[0-9]+"] )] // c'est une regEx, expression régulière; le parametre = au moins un chiffre de 0 à 9, il peut etre utilisé plusieurs fois (d'où le +); si à la place de + on met *, ça veut dire qu'il peut être rien du tout au minimum. Et si ?, alors il peut être qu'un seul chiffre (à vérifier, pas sûr).
    // Si on met pas le regEx, ça envoi une erreur 500 (erreur du code), alors que si on le met et après il y a un caractère au lieu des chiffres dans URL, ça met un 404 (chemin n'est pas trouvé), c'est pas le même type d'erreur (c'est mieux en gros)
    public function conditions(int $parametre)
    {
        return $this->render("test/conditions.html.twig", ["a" => $parametre ]);
    }

    /* Exo :
    - créer une route pour le chemin /test/calcul/a/b qui récupère la valeur de a et de b dans l'URL et qui affiche la somme des 2 valeurs
    - Restriction : a et b doivent être des paramètres numériques
    */

    #[Route("/test/calcul/{a}/{b}",requirements: ["a" => "[0-9]+", "b" => "[0-9]+"] )]
    public function calcul(int $a, int $b)
    {
        return $this->render("test/calcul.html.twig", ["a" => $a, "b" => $b ]);
    }

    #[Route("/test/boucles")]
    public function boucles()
    {
        $array = ["je", "m'appelle", "Gérard", "Mentor"];
        $tab = [
            "nom" => "Cérien",
            "prenom" => "Jean",
            "age" => 99
        ];
        return $this->render("test/boucles.html.twig",
        [
            "tableau" => $array,
            "personne" =>$tab
        ]);
    }

    #[Route("/test/objet")]
    public function objet()
    {
        $personne = new \stdClass; // c'est une class PHP qui permet de créer un objet sans avoir à définir une class
        // \ backslash c'est pour sortir du "namespace (chemin pour accéder à une class)"; sinon il va chercher la class stdClass dans namespace App\Controller (et ne va pas la trouver)
        $personne->nom = "Onym";
        $personne->prenom = "Anne";
        $personne->age = "35";
        $tab = [
            "nom" => "Cérien",
            "prenom" => "Jean",
            "age" => 99
        ];
        // ça va marcher aussi avec $tab dans le fichier twig c'est toujours pareil (personne.nom) peu importe tableau ou objet
    
        return $this->render("test/objet.html.twig", ["personne" => $personne]);
    }

}

<?php

namespace App\Controllers;

class CoreController
{
    protected $router;


    public function __construct($routeName, $router)
    {
    // Stock l'instance d'altorouter en lieux surs
    $this->router = $router;

    $acl = [
        "main-home" => [],
        "teacher-list" => ["admin", "user"],
        "teacher-add" => ["admin"],
        "teacher-insert" => ["admin"],
        "student-list" => ["admin", "user"],
        "student-add" => ["admin"],
        "student-insert" => ["admin"],
    ];

    if ( isset($acl[$routeName]) ) {
        // Extraction des roles de l'acl
        $roles = $acl[$routeName];

        $this->checkAuthorization($roles);
    }
    }        
    /**
     * Méthode permettant d'afficher du code HTML en se basant sur les views
     *
     * @param string $viewName Nom du fichier de vue
     * @param array $viewData Tableau des données à transmettre aux vues
     * @return void
     */
    protected function show(string $viewName, $viewData = [])
    {
        // Comme $viewData est déclarée comme paramètre de la méthode show()
        // les vues y ont accès
        // ici une valeur dont on a besoin sur TOUTES les vues
        // donc on la définit dans show()
        $viewData['currentPage'] = $viewName;

        // définir l'url absolue pour nos assets
        $viewData['assetsBaseUri'] = $_SERVER['BASE_URI'] . 'assets/';
        // définir l'url absolue pour la racine du site
        // /!\ != racine projet, ici on parle du répertoire public/
        $viewData['baseUri'] = $_SERVER['BASE_URI'];

        // On veut désormais accéder aux données de $viewData, mais sans accéder au tableau
        // La fonction extract permet de créer une variable pour chaque élément du tableau passé en argument
        extract($viewData);
        // => la variable $currentPage existe désormais, et sa valeur est $viewName
        // => la variable $assetsBaseUri existe désormais, et sa valeur est $_SERVER['BASE_URI'] . '/assets/'
        // => la variable $baseUri existe désormais, et sa valeur est $_SERVER['BASE_URI']
        // => il en va de même pour chaque élément du tableau

        // $viewData est disponible dans chaque fichier de vue
        require_once __DIR__ . '/../views/layout/header.tpl.php';
        require_once __DIR__ . '/../views/' . $viewName . '.tpl.php';
        require_once __DIR__ . '/../views/layout/footer.tpl.php';
    }


    public function checkAuthorization ($roles=[]) {
        // Si le user est connecté
        if ( isset($_SESSION['userId']) && isset($_SESSION['userObject']) ) {
            // Alors on récupère l'utilisateur connecté
            $user = $_SESSION['userObject'];

            // Puis on récupère son role
            $userRole = $user->getRole();

            // si le role fait partie des roles autorisées (fournis en paramètres)
            // ou que tous les rôles sont ok
            if ( count($roles) === 0 || in_array($userRole, $roles) ) {
                // Alors on retourne vrai
                return true;
            }
            // Sinon le user connecté n'a pas la permission d'accéder à la page
            else {
                // => on envoie le header "403 Forbidden"
                http_response_code(403);
                // Puis on affiche la page d'erreur 403
                $this->show('error/err403', [
                    "errors" => [
                        "Page non accessible en tant que $userRole"
                    ]
                ]);
                // Enfin on arrête le script pour que la page demandée ne s'affiche pas
                exit;
            }
        }
        // Sinon, l'internaute n'est pas connecté à un compte
        else {
            // Alors on le redirige vers la page de connexion
            header('Location: /signin');
            exit;
        }
    }
}
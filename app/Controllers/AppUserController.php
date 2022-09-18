<?php

namespace App\Controllers;
use App\Models\AppUser;

class AppUserController extends CoreController
{
    /**
     * Méthode s'occupant de la page d'accueil
     *
     * @return void
     */
    public function loginForm()
    {
        // On appelle la méthode show() de l'objet courant
        // On lui passe la liste des teachers via la méthode findAll()
        $this->show('main/signin');
    }

    public function connect()
    {
        // Extraction des données du formulaire
        $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
        $password = filter_input(INPUT_POST, 'password');

        // Vérifie l'intégrité des données transmises
        $errors = [];
        if ( empty($email) || $email === false ) {
            $errors[] = "Email invalide";
        }
        if ( empty($password) ) {
            $errors[] = "Mot de passe vide";
        }

        // uniquement si pas d'erreur dans les données transmisses
        if ( count($errors) === 0 ) {
            // Recherche l'utilisateur par email avec une méthode spécifique
            $user = AppUser::findByEmail($email);
    
            // Vérifie qu'on a bien trouvé un utlisateur
            if ( $user === false ) {
                $errors[] = "Utilisateur inconnu";
            }
            // else if ( $user->getPassword() !== password_hash($password, PASSWORD_DEFAULT) ) {
            else if ( !password_verify($password, $user->getPassword()) ) {
                $errors[] = "Mot de passe incorrect";
            }
            else {
                // Ici je suis sûr de l'identité de l'utilisateur
                // Je sauvegarde en session ses infos
                $_SESSION['userId'] = $user->getId();
                $_SESSION['userObject'] = $user;

                header('Location: /');
            }
        }

        
        // Recharge la vue formulaire avec les erreurs
        $this->show('main/signin', [
            "errors" => $errors
        ]);
    }

        /**
     * Suppression de l'utilisateur en session
     *
     * @return void
     */
    public function logout () {
        unset($_SESSION['userId']);
        unset($_SESSION['userObject']);

        header('Location: /signin');
    }
}
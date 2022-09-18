<?php

namespace App\Controllers;
use App\Models\Teacher;

class MainController extends CoreController
{
    /**
     * Méthode s'occupant de la page d'accueil
     *
     * @return void
     */
    public function home()
    {
        // On appelle la méthode show() de l'objet courant
        // On lui passe la liste des teachers via la méthode findAll()
        $this->show('main/home');
    }
}
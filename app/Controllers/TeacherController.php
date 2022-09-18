<?php

namespace App\Controllers;
use App\Models\Teacher;

class TeacherController extends CoreController
{
    /**
     * Méthode s'occupant de la page qui liste les teachers
     *
     * @return void
     */
    public function list()
    {
        // On appelle la méthode show() de l'objet courant
        // On lui passe la liste des teachers via la méthode findAll()
        $this->show('teachers/list', [
            "teachersList" => Teacher::findAll()
        ]);
    }

    public function add()
    {
        // On appelle la méthode show() de l'objet courant
        // On lui demande de montrer le formulaire d'ajout d'un teacher
        $this->show('teachers/add');
    }

    public function insert()
    {
        $firstname = filter_input(INPUT_POST, 'firstname');
        $lastname = filter_input(INPUT_POST, 'lastname');
        $job = filter_input(INPUT_POST, 'job');
        $status = filter_input(INPUT_POST, 'status', FILTER_VALIDATE_INT);

        // On crée un nouveau Model
        $teacher = new Teacher();

        // On renseigne les propriétés
        $teacher->setFirstname($firstname);
        $teacher->setLastname($lastname);
        $teacher->setJob($job);
        $teacher->setStatus($status);

        // On sauvegarde en DB
        if ($teacher->save()) {
            header("Location: /teachers");
        }
    }
}
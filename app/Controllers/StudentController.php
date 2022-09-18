<?php

namespace App\Controllers;
use App\Models\Student;

class StudentController extends CoreController
{
    /**
     * Méthode s'occupant de la page qui liste les students
     *
     * @return void
     */
    public function list()
    {
        // On appelle la méthode show() de l'objet courant
        // On lui passe la liste des students via la méthode findAll()
        $this->show('students/list', [
            "studentList" => Student::findAll()
        ]);
    }

    public function add()
    {
        // On appelle la méthode show() de l'objet courant
        // On lui demande de montrer le formulaire d'ajout d'un student
        $this->show('students/add');
    }

    public function insert()
    {
        $firstname = filter_input(INPUT_POST, 'firstname');
        $lastname = filter_input(INPUT_POST, 'lastname');
        $status = filter_input(INPUT_POST, 'status', FILTER_VALIDATE_INT);
        $teacherId = filter_input(INPUT_POST, 'teacher', FILTER_VALIDATE_INT);

        // On crée un nouveau Model
        $student = new Student();

        // On renseigne les propriétés
        $student->setFirstname($firstname);
        $student->setLastname($lastname);
        $student->setTeacherId($teacherId);
        $student->setStatus($status);

        // On sauvegarde en DB
        if ($student->save()) {
            header("Location: /students");
        }
    }
}
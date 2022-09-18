<?php

namespace App\Models;

use App\Utils\Database;
use PDO;

class Teacher extends Coremodel {

    // Setter des propriétés issues de CoreModel

    /**
     * Set the value of id
     *
     * @param  int  $id
     *
     * @return  self
     */ 
    public function setId(int $id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Set the value of created_at
     *
     * @param  string  $created_at
     *
     * @return  self
     */ 
    public function setCreated_at(string $created_at)
    {
        $this->created_at = $created_at;

        return $this;
    }

    /**
     * Set the value of updated_at
     *
     * @param  string  $updated_at
     *
     * @return  self
     */ 
    public function setUpdated_at(string $updated_at)
    {
        $this->updated_at = $updated_at;

        return $this;
    }

    // Propriétés issues de la table teacher qui ne sont pas reprises dans le CoreModel suivi des Getter et Setter

    private $firstname;
    private $lastname;
    private $job;
    private $status;


    


    /**
     * Get the value of firstname
     */ 
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * Set the value of firstname
     *
     * @return  self
     */ 
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;

        return $this;
    }

    /**
     * Get the value of lastname
     */ 
    public function getLastname()
    {
        return $this->lastname;
    }

    /**
     * Set the value of lastname
     *
     * @return  self
     */ 
    public function setLastname($lastname)
    {
        $this->lastname = $lastname;

        return $this;
    }

    /**
     * Get the value of job
     */ 
    public function getJob()
    {
        return $this->job;
    }

    /**
     * Set the value of job
     *
     * @return  self
     */ 
    public function setJob($job)
    {
        $this->job = $job;

        return $this;
    }

    /**
     * Get the value of status
     */ 
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set the value of status
     *
     * @return  self
     */ 
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    // Déclaration des méthodes asbtraites issues du CoreModel

    public static function findAll()
    {
        $pdo = Database::getPDO();
        $sql = 'SELECT * FROM `teacher`';
        $pdoStatement = $pdo->query($sql);
        $results = $pdoStatement->fetchAll(PDO::FETCH_CLASS, 'App\Models\Teacher');

        return $results;
    }

    public static function find($id)
    {

    }

    public function update()
    {

    }

    public function insert()
    {
        // Get pdo instance
        $pdo = Database::getPDO();

        // Write the sql request without data directly, use key to bind values after
        $sql = "
            INSERT INTO `teacher` (firstname, lastname, job, status)
            VALUES (:firstname, :lastname, :job, :status)
        ";

        // Prepare the request with pdo instance
        $sth = $pdo->prepare($sql);

        // Bind values according to data type
        $sth->bindValue('firstname', $this->firstname, PDO::PARAM_STR);
        $sth->bindValue('lastname', $this->lastname, PDO::PARAM_STR);
        $sth->bindValue('job', $this->job, PDO::PARAM_STR);
        $sth->bindValue('status', $this->status, PDO::PARAM_INT);

        // Execute the request and get sucess or fail
        $success = $sth->execute();

        // Check success and number of row modified
        if ( $success && $sth->rowCount() === 1 ) {

            // Get inserted id to fill id property in this object
            $this->id = $pdo->lastInsertId();

            return true;
        }

        return false;
    }
}
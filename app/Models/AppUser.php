<?php
namespace App\Models;

use App\Utils\Database;
use PDO;

class AppUser extends Coremodel {

    /* PROPERTIES */ 
    /**
     * @var string
     */
    private $email;

    /**
     * @var string
     */
    private $password;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $role;

    /**
     * @var int
     */
    private $status;



    /* GETTER / SETTER */
    public function getPassword () {
        return $this->password;
    }
    public function setPassword ($pwd) {
        $this->password = password_hash($pwd, PASSWORD_DEFAULT);
    }
    public function getRole () {
        return $this->role;
    }
    public function setRole ($role) {
        $this->role = $role;
    }
    public function getEmail () {
        return $this->email;
    }
    public function setEmail ($email) {
        $this->email = $email;
    }
    public function getStatus () {
        return $this->status;
    }
    public function setStatus ($status) {
        $this->status = $status;
    }
    public function getName() {
        return $this->name;
    }
    public function setName(string $name)  {
        $this->name = $name;
    }
    


    /* METHODS */
    /**
     * Méthode permettant de récupérer un enregistrement de la table app_user en fonction d'un id donné
     *
     * @param int $id ID de l'utilisateur
     * @return AppUser
     */
    public static function find($id)
    {
    }

    
    /**
     * Méthode permettant de récupérer tous les enregistrements de la table app_user
     *
     * @return AppUser[]
     */
    public static function findAll()
    {
    }


    /**
     * Recherche un utilisateur en fonciton de son email
     *
     * @param [type] $email
     * @return AppUser
     */
    public static function findByEmail ($email) {
        // se connecter à la BDD
        $pdo = Database::getPDO();

        // écrire notre requête
        $sql = 'SELECT * FROM `app_user` WHERE `email` = :email';

        // Préparation de la requete pour eviter les injections SQL
        $sth = $pdo->prepare($sql);
        $sth->bindValue('email', $email);

        // Exécution de la requête
        $sth->execute();

        // un seul résultat => fetchObject
        // self::class évite de retaper le FQCN de la classe !
        $user = $sth->fetchObject(self::class);

        // retourner le résultat
        return $user;
    }




    /**
     * Insert a new user into app_user
     *
     * @return void
     */
    public function insert () 
    {

    }


    /**
     * Save user into db
     *
     * @return void
     */
    public function update () 
    {

    }
}
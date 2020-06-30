<?php

namespace App\Models;

use App\Utils\Database;
use PDO;

class AppUser extends CoreModel{

    private $email;
    private $password;
    private $firstname;
    private $lastname;
    private $role;
    private $status;

    /**
     * Get the value of email
     */ 
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set the value of email
     *
     * @return  self
     */ 
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get the value of password
     */ 
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set the value of password
     *
     * @return  self
     */ 
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

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
     * Get the value of role
     */ 
    public function getRole()
    {
        return $this->role;
    }

    /**
     * Set the value of role
     *
     * @return  self
     */ 
    public function setRole($role)
    {
        $this->role = $role;

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

    /**
     * Affiche un objet représentant les données d'un utilisateur
     * @return AppUser
     */
    public static function find($user){

        $pdo = Database::getPDO();
        $sql = 'SELECT * FROM `app_user` WHERE id = ' . $user;
        $statement = $pdo->query($sql);
        $user = $statement->fetchObject('App\Models\AppUser');

        return $user;
    }
    /**
     * Méthode d'insertion d'un nouvel utilisateur
     * @return bool
     *      
     */
    public function insert(){
        $pdo = Database::getPDO();
        $sql = "
            INSERT INTO `app_user` (`email`, `password`, `firstname`, `lastname`, `role`, `status`) VALUES (:email, :password, :firstname, :lastname, :role, :status)
        ";

        $statement = $pdo->prepare($sql);
        $insert = $statement->execute([
            ':email' => $this->email,
            ':password' => $this->password,
            ':firstname' => $this->firstname,
            ':lastname' => $this->lastname,
            ':role' => $this->role,
            ':status' => $this->status
        ]);

        if($insert){
            $this->id = $pdo->lastInsertId();
            return true;
        }

        return false;
    }

    /**
     * Méthode permettant d'afficher un objet de la table app_user
     * @return AppUser
     */
    public static function findByEmail($email){
        
        $pdo = Database::getPDO();
        $sql = 'SELECT * FROM `app_user` WHERE `email` = :email';
        $statement = $pdo->prepare($sql);

        $statement->bindValue(':email', $email);
        $statement->execute();

        $user = $statement->fetchObject('App\Models\AppUser');

        return $user;
    }

    /**
     * Méthode permettant d'afficher tout les objet de la table app_user
     * @return AppUser[]
     */
    public static function findAll(){
        $pdo = Database::getPDO();
        $sql = "
            SELECT * 
            FROM `app_user`"
        ;
        $statement = $pdo->query($sql);
        $users = $statement->fetchAll(PDO::FETCH_CLASS, 'App\Models\AppUser');

        return $users;
    }

    /**
     * Méthode permettant de mettre à jour les données d'un user
     * @return bool
     */
    public function update(){

        global $router;

        $pdo = Database::getPDO();
        $sql = "
            UPDATE `app_user`
            SET
                email = :email,
                password = :password,
                firstname = :firstname,
                lastname = :lastname,
                role = :role,
                status = :status,
                updated_at = NOW()
            WHERE id = :userId
        ";
        $statement = $pdo->prepare($sql);
        $success = $statement->execute([
            ':email' => $this->email,
            ':password' => $this->password,
            ':firstname' => $this->firstname,
            ':lastname' => $this->lastname,
            ':role' => $this->role,
            ':status' => $this->status,
            ':id' => $this->id
        ]);

        if($success){
            return $success;
            header('Location: ' . $router->generate('main-home'));
        }else{
            header('Location: ' . $router->generate('main-home', ['userId' => $this->id]));
        }
    }

    /**
     * Supprime la ligne de l'utilisateur seléctionné
     * @return bool
     */
     public function delete($userId){
         
         $pdo = Database::getPDO();
         $sql = 'DELETE FROM `app_user` WHERE `id` = ' . $userId;
         $statement = $pdo->exec($sql);

         if($statement){
             return true;
         }

         return false;
     }
}
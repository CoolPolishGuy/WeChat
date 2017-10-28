<?php
/**************************************************
* STI - Project Web
* WeChat
* Description: web site to sen mails between users 
* Authors: Loan Lassalle, Wojciech Myszkorowski
**************************************************/

require_once('Authentication.php');
require_once('Database.php');
require_once('Mail.php');
require_once('Utils.php');

/**
 * Gère les utilisateurs
 *
 * @author Lassalle Loan, Wojciech Myszkorowski
 * @since 27.09.2017
 */
class User {
    private static $_instance;
    
    private function __construct() {
    }

    public static function getInstance() {
        if (is_null(self::$_instance )) {
          self::$_instance = new self();
        }
        
        return self::$_instance;
    }
    
    /**
     * Récupère l'ID de l'utilisateur
     */
    public function getId() {
        return Database::getInstance()->query("SELECT id
                                                FROM users
                                                WHERE digest='{$_SESSION['digest']}';");
    }
    
    /**
     * Récupère l'ID d'un utilisateur
     */
    public function getIdByUsername($username) {
        return Database::getInstance()->query("SELECT id
                                                FROM users
                                                WHERE username='{$username}';");
    }
    
    /**
     * Récupère le nom d'utilisateur de l'utilisateur
     */
    public function getUsername() {
        return Database::getInstance()->query("SELECT username
                                                FROM users
                                                WHERE digest='{$_SESSION['digest']}';");
    }
    
    /**
     * Récupère les credentials de l'utilisateur
     */
    public function getCredentials() {
        return Database::getInstance()->query("SELECT salt,
                                                digest
                                                FROM users
                                                WHERE digest='{$_SESSION['digest']}';");
    }
    
    /**
     * Récupère les credentials d'un utilisateur
     */    
    public function getCredentialsByUsername($username) {
        return Database::getInstance()->query("SELECT salt,
                                                digest
                                                FROM users
                                                WHERE username='{$username}';");
    }
    
    /**
     * Récupère le rôle d'un utilisateur
     */
    public function getRole() {
        return Database::getInstance()->query("SELECT role
                                                FROM users
                                                WHERE digest='{$_SESSION['digest']}';");
    }
    
    /**
     * Récupère le rôle d'un utilisateur
     */
    public function getRoleByUsername($username) {
        return Database::getInstance()->query("SELECT role
                                                FROM users
                                                WHERE username='{$username}';");
    }
    
    /**
     * Récupère l'état d'un utilisateur
     */
    public function getActive() {
        return Database::getInstance()->query("SELECT active
                                                FROM users
                                                WHERE digest='{$_SESSION['digest']}';");
    }
    
    /**
     * Récupère l'état d'un utilisateur
     */
    public function getActiveByUsername($username) {
        return Database::getInstance()->query("SELECT active
                                                FROM users
                                                WHERE username='{$username}';");
    }

    /**
     * Récupère les informations d'un utilisateur
     */
    public function getUser($id) {
        return Database::getInstance()->query("SELECT username,
                                                active,
                                                name AS role
                                                FROM users 
                                                INNER JOIN roles ON users.role = roles.id
                                                WHERE users.id={$id};"); 
    }

    /**
     * Récupère les informations de l'utilisateur
     */
    public function getData() {
        return Database::getInstance()->query("SELECT users.id,
                                                username,
                                                active,
                                                name AS role
                                                FROM users 
                                                INNER JOIN roles ON users.role = roles.id
                                                WHERE digest<>'{$_SESSION['digest']}';");  
    }

    /**
     * Récupère la table complète
     */
    public function getTable() {
        return Database::getInstance()->query("SELECT * FROM users;");  
    }
    
    /**
     * Insère un utilisateur
     */
    public function insertOne($user) {
        $user['salt'] = Utils::getInstance()->randomStr();
        $user['digest'] = Authentication::getInstance()->getDigest("{$user['username']}{$user['salt']}{$user['password']}");
        Database::getInstance()->query("INSERT INTO users (username, salt, digest, active, role) 
                                        VALUES ('{$user['username']}', '{$user['salt']}', '{$user['digest']}','{$user['active']}', '{$user['role']}');");
    }
    
    /**
     * Insère des utilisateurs
     */
    public function insertMultiple($userArray) {
        foreach ($userArray as $user) {
            $this->insertOne($user);
        }
    }
    
    /**
     * Met à jour l'empreinte de l'utilisateur
     */
    public function updateDigest($digest) {
        Database::getInstance()->query("UPDATE users
                                        SET digest='{$digest}'
                                        WHERE digest='{$_SESSION['digest']}';");      
    }
    
    /**
     * Met à jour un utilisateur
     */
    public function updateOne($user) {
        $setDigest = '';
        
        if (isset($user['digest'])) {
            $setDigest = "digest='{$user['digest']}',";
        }
        
        Database::getInstance()->query("UPDATE users
                                        SET {$setDigest}
                                        active={$user['active']},
                                        role={$user['role']}
                                        WHERE id={$user['id']};");       
    }
    
    /**
     * Met à jour des utilisateur
     */
    public function updateMultiple($userArray) {
        foreach ($userArray as $user) {
            $this->updateOne($user);
        }
    }
    
    /**
     * Supprime un utilisateur
     */
    public function deleteOne($id) {
        Mail::getInstance()->updateOne($id);
        Database::getInstance()->query("DELETE FROM users
                                        WHERE id={$id};");
    }
    
    /**
     * Supprime des utilisateurs
     */
    public function deleteMultiple($idArray) {
        foreach ($idArray as $id) {
            $this->deleteOne($id);
        }
    }
}
?>

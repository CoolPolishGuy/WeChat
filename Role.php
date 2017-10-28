<?php
/**
 * STI - Project Web
 * WeChat
 * Description: web site to send mails between users 
 * Authors: Loan Lassalle, Wojciech Myszkorowski
 */

require_once('Database.php');

/**
 * Gère les rôles
 *
 * @author Lassalle Loan, Wojciech Myszkorowski
 * @since 27.09.2017
 */
class Role {
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
     * Récupère l'ID d'un rôle
     */
    public function getId($name) {
        return Database::getInstance()->query("SELECT id
                                                FROM roles
                                                WHERE id={$name};");  
    }
    
    /**
     * Récupère le nom d'un rôle
     */
    public function getName($id) {
        return Database::getInstance()->query("SELECT name
                                                FROM roles
                                                WHERE id={$id};");  
    }
    
    /**
     * Récupère la date d'un rôle
     */
    public function getData($id) {
        return Database::getInstance()->query("SELECT id,
                                                name
                                                FROM roles
                                                WHERE id={$id};");  
    }

    /**
     * Récupère la table complète
     */
    public function getTable() {
        return Database::getInstance()->query("SELECT * FROM roles;");  
    }
    
    /**
     * Insère un rôle
     */
    public function insertOne($role) {
        Database::getInstance()->query("INSERT INTO roles (name) 
                                        VALUES ('{$role['name']}');");
    }
    
    /**
     * Insère des rôles
     */
    public function insertMultiple($roleArray) {
        foreach ($roleArray as $role) {
            $this->insertOne($role);
        }
    }
    
    /**
     * Met à jour un rôle
     */
    public function updateOne($role) {        
        Database::getInstance()->query("UPDATE roles
                                        SET name={$role['name']}
                                        WHERE id={$role['id']};");       
    }
    
    
    /**
     * Met à jour des rôles
     */
    public function updateMultiple($roleArray) {
        foreach ($roleArray as $role) {
            $this->updateOne(role);
        }
    }
}
?>

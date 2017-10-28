<?php
/**
 * STI - Project Web
 * WeChat
 * Description: web site to send mails between users 
 * Authors: Loan Lassalle, Wojciech Myszkorowski
 */
 
/**
 * Gère l'authentification et la redirection du l'utilisateur
 *
 * @author Lassalle Loan, Wojciech Myszkorowski
 * @since 27.09.2017
 */
class Authentication {
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
     * Récupère l'empreinte dd'un chaîne de caractères
     */
    public function getDigest($str) {
        return base64_encode(hash('sha512', $str, true));
    }

    /**
     * Vérifie si l'utilisateur est authentifié et autorisé
     */
    public function isLogged() {
        session_start();
        
        return isset($_SESSION['logged']) && $_SESSION['logged'];
    }

    /**
     * Vérifie si l'utilisateur n'est pas authentifié et autorisé
     */
    public function isNotLogged() {
        return !$this->isLogged();
    }

    /**
     * Redirige l'utilisateur selon une condition
     */
    public function goToLocation($cond, $location = 'index.php') {
        if ($cond) {
            header("location:{$location}");
        }
    }
}
?>
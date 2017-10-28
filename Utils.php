<?php
/**
 * STI - Project Web
 * WeChat
 * Description: web site to send mails between users 
 * Authors: Loan Lassalle, Wojciech Myszkorowski
 */

/**
 * Boîte à outils
 *
 * @author Lassalle Loan, Wojciech Myszkorowski
 * @since 27.09.2017
 */
class Utils {
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
     * Formate une date en chaîne de caractères
     */
    public function dateStrFormat($date, $timeZone = 'UTC', $format = 'm.d.Y H:i') {
        return (new DateTime($date, new DateTimeZone($timeZone)))->format($format);
    }

    /**
     * Génère une chaîne de caractères aléatoire
     */
    function randomStr($length = 255, $keyspace = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ') {
        $str = '';
        $max = strlen($keyspace) - 1;
        
        for ($i = 0; $i < $length; ++$i) {
            $str .= $keyspace[mt_rand(0, $max)];
        }
        
        return $str;
    }
}
?>

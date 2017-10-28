<?php
/**
 * STI - Project Web
 * WeChat
 * Description: web site to send mails between users 
 * Authors: Loan Lassalle, Wojciech Myszkorowski
 */

extract(@$_POST);
require_once('Authentication.php');
require_once('Database.php');
require_once('User.php');

// Redirige l'utilisateur vers index.php
Authentication::getInstance()->goToLocation(Authentication::getInstance()->isNotLogged());

// Récupère le nom d'utilisateur, le sel et l'empreinte de l'utilisateur
$username = User::getInstance()->getUsername()->fetch()['username'];
$salt = User::getInstance()->getCredentialsByUsername($username)->fetch()['salt'];
$oldDigest = Authentication::getInstance()->getDigest("{$username}{$salt}{$oldPassword}");

// Autorise et authentifie l'utilisateur
if ($_SESSION['digest'] === $oldDigest && $newPassword === $confirmPassword) {
    $newDigest = Authentication::getInstance()->getDigest("{$username}{$salt}{$newPassword}");
    User::getInstance()->updateDigest($newDigest);
    
    $_SESSION['digest'] = $newDigest;
    header('location:logout.php');
} else {
    header('location:changePassword.php?error=1');
}

// Ferme la connexion à la base de données
Database::getInstance()->deconnection();
?>
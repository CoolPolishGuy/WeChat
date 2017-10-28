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
session_start();

// Redirige l'utilisateur vers home.php
if (isset($_SESSION['logged']) && $_SESSION['logged']) {
    header("location:home.php");
    exit();
}

// Récupère les credentials de l'utilisateur
$credentials = User::getInstance()->getCredentialsByUsername($username)->fetch();

// Calcule l'empreinte de l'utilisateur
$digest = Authentication::getInstance()->getDigest("{$username}{$credentials['salt']}{$password}");

// Récupère l'état du compte de l'utilisateur
$active = User::getInstance()->getActiveByUsername($username)->fetch()['active'];

// Ferme la connexion à la base de données
Database::getInstance()->deconnection();

// Autorise et authentifie l'utilisateur
$_SESSION['logged'] = $credentials['digest'] === $digest && $active;

// Redirige l'utilisateur
if ($_SESSION['logged']) {
    $_SESSION['digest'] = $digest;
    
	header('location:home.php');
} else {	
	header('location:index.php');
}
?> 

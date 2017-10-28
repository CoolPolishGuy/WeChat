<?php
/**
 * STI - Project Web
 * WeChat
 * Description: web site to send mails between users 
 * Authors: Loan Lassalle, Wojciech Myszkorowski
 */

require_once('Database.php');

session_start();
session_destroy();

// Ferme la connexion à la base de données
Database::getInstance()->deconnection();

// Redirige l'utilisateur vers index.php
header('location:index.php');
?> 

<?php
/**
 * STI - Project Web
 * WeChat
 * Description: web site to send mails between users 
 * Authors: Loan Lassalle, Wojciech Myszkorowski
 */

require_once('Database.php');
require_once('Mail.php');
require_once('Role.php');
require_once('User.php');

// Récupère les données de la base de données
$roles = Role::getInstance()->getTable();
$users = User::getInstance()->getTable();
$mails = Mail::getInstance()->getTable();

// Ferme la connexion à la base de données
Database::getInstance()->deconnection();
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
    <head>
        <title>WeChat - Show data</title>
        <meta http-equiv="content-type" content="text/html; charset=utf-8"/>
    </head>
    <body style="background-image: url(./images/background.jpg)">
        <h1>Show data</h1>
        <h2>Roles</h2>
        <?php
        
        // Affiche les roles
        foreach($roles as $row) {
            echo "Name: {$row['name']}
                <br/>";
        }
        ?>
        <h2>Users</h2>
        <?php
        
        // Affiche les utilisateurs
        foreach($users as $row) {
            echo "Username: {$row['username']}
                <br/>
                Active: {$row['active']}
                <br/>
                Role: {$row['role']}
                <br/>
                <br/>";
        }
        ?>
        <h2>Mails</h2>
        <?php
        
        // Affiche les emails
        foreach($mails as $row) {
            echo "Date: {$row['date']}
                <br/>
                idSender: {$row['idSender']}
                <br/>
                idReceiver: {$row['idReceiver']}
                <br/>
                Subject: {$row['subject']}
                <br/>
                Body: {$row['body']}
                <br/>
                <br/>";
        }
        ?>
    </body>
</html>
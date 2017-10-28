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
require_once('Utils.php');

// Redirige l'utilisateur vers index.php
Authentication::getInstance()->goToLocation(Authentication::getInstance()->isNotLogged());

// Récupère l'ID de l'utilisateur
$id = User::getInstance()->getIdByUsername($username)->fetch()['id'];

if (!isset($id)) {
    
    // Insère un utilisateur
    $user = array('username' => $username,
                    'password' => $password,
                    'active' => isset($active) ? 1 : 0,
                    'role' => $role);
    
    User::getInstance()->insertOne($user);
    header('location:home.php');
} else if (empty($password) && empty($confirmPassword)) {   

    // Met à jour l'utilisateur sans mettre à jour le mot de passe
    $user = array('id' => $id,
                    'active' => isset($active) ? 1 : 0,
                    'role' => $role);
    
    User::getInstance()->updateOne($user);
    header('location:home.php');
} else if ($password === $confirmPassword) {
    
    // Met à jour l'utilisateur et son mot de passe
    $credentials = User::getInstance()->getCredentialsByUsername($username)->fetch();
    $digest = Authentication::getInstance()->getDigest("{$username}{$credentials['salt']}{$password}");
    
    $user = array('id' => $id,
                    'digest' => $digest,
                    'active' => isset($active) ? 1 : 0,
                    'role' => $role);
    
    User::getInstance()->updateOne($user);
    header('location:home.php');
} else {
    header('location:manageUser.php?id='.$id.'&error=true');
}

// Ferme la connexion à la base de données
Database::getInstance()->deconnection();
?>
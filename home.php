<?php
/**
 * STI - Project Web
 * WeChat
 * Description: web site to send mails between users 
 * Authors: Loan Lassalle, Wojciech Myszkorowski
 */

require_once('Authentication.php');
require_once('Database.php');
require_once('Mail.php');
require_once('User.php');
require_once('Utils.php');

// Redirige l'utilisateur vers index.php
Authentication::getInstance()->goToLocation(Authentication::getInstance()->isNotLogged());

// Récupère les emails reçus
$mails = Mail::getInstance()->getData();
$mail = $mails->fetch();

// Récupère le rôle de l'utilisateur
$role = User::getInstance()->getRole()->fetch()['role'] === '1';

if ($role) {
    
    // Récupère les utilisateurs
    // en fonction du rôle de l'utilisateur connecté
    $users = User::getInstance()->getData();
    $user = $users->fetch();
}

// Ferme la connexion à la base de données
Database::getInstance()->deconnection();
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
    <head>
        <title>WeChat - Home</title>
        <meta http-equiv="content-type" content="text/html; charset=utf-8"/>
    </head>
    <body style="background-image: url(./images/background.jpg)">
        <h1>Home</h1>
        <br>
        <a href="logout.php">Logout</a>
        <br>
        <br>
        <a href="changePassword.php">Change Password</a>
        <br>
        <br>
        <table width="500px">
            <?php
            if ($mail) {                
                echo '<tr>';
                
                // Affiche les en-têtes des colonnes
                for ($i = 1; $i < $mails->columnCount(); $i++) {
                    echo '<th>'.ucfirst($mails->getColumnMeta($i)['name']).'</th>';
                }
                
                echo '<th colspan="3" >
                    <input type="button" value="New Mail" onclick="window.location.href=\'writeMail.php\';" style="background-color: deepskyblue; font-size: medium;" >
                    </th>
                    </tr>';
                
                // Affiche les emails reçus
                do {
                    echo "<tr align=\"center\">
                        <td>".Utils::getInstance()->dateStrFormat($mail['date'])."</td>
                        <td>{$mail['from']}</td>
                        <td>{$mail['subject']}</td>
                        <td>
                        <input type=\"button\" value=\"More\" onclick=\"window.location.href='readMail.php?id={$mail['id']}';\">
                        </td>
                        <td>
                        <input type=\"button\" value=\"Reply\" onclick=\"window.location.href='writeMail.php?id={$mail['id']}';\">
                        </td>
                        <td>
                        <input type=\"button\" value=\"Delete\" onclick=\"window.location.href='deleteMail.php?id={$mail['id']}';\">
                        </td>
                        </tr>";
                } while ($mail = $mails->fetch());
            
                if ($role) {
                    echo '<tr>
                        <td colspan="6">
                        <br>
                        </td>
                        </tr>';
                }
            }
            
            if ($role && $user) {
                echo '<tr>';
                
                // Affiche les en-têtes des colonnes
                for ($i = 1; $i < $users->columnCount(); $i++) {
                    echo '<th>'.ucfirst($users->getColumnMeta($i)['name']).'</th>';
                }
                
                echo '<th colspan="3">
                    <input type="button" value="New User" onclick="window.location.href=\'manageUser.php\';">
                    </th>
                    </tr>';
                
                // Affiche les informations des utilisateurs
                do {
                    echo "<tr align=\"center\">
                        <td>{$user['username']}</td>
                        <td>{$user['active']}</td>
                        <td>{$user['role']}</td>
                        <td>
                        <input type=\"button\" value=\"Manage\" onclick=\"window.location.href='manageUser.php?id={$user['id']}';\">
                        </td>
                        <td>
                        </td>
                        <td>
                        <input type=\"button\" value=\"Delete\" onclick=\"window.location.href='deleteUser.php?id={$user['id']}';\">
                        </td>
                        </tr>";
                } while ($user = $users->fetch());
            }
            ?>
        </table>
	</body>
</html>

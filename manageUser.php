<?php
/**
 * STI - Project Web
 * WeChat
 * Description: web site to send mails between users 
 * Authors: Loan Lassalle, Wojciech Myszkorowski
 */

extract(@$_GET);
require_once('Authentication.php');
require_once('Database.php');
require_once('User.php');

// Redirige l'utilisateur vers index.php
Authentication::getInstance()->goToLocation(Authentication::getInstance()->isNotLogged());

$valueUsername = '';
$styleUsername = '';
    
$activeChecked = 'checked';

$roleAdministrator = '';
$roleCoWorker = 'checked';

// Si un utilisateur est sélectionné
if (isset($id)){
    $user = User::getInstance()->getUser($id)->fetch();
    
    $valueUsername = 'value="'.$user['username'].'"';
    $styleUsername = 'style="border:none" readonly';
    
    if (!$user['active']) {
        $activeChecked = '';
    }

    if ($user['role'] === 'Administrator') {
        $roleAdministrator = 'checked';
        $roleCoWorker = '';
    }
}

// Ferme la connexion à la base de données
Database::getInstance()->deconnection();
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
    <head>
        <title>WeChat - Users manager</title>
        <meta http-equiv="content-type" content="text/html; charset=utf-8"/>
    </head>
    <body style="background-image: url(./images/background.jpg)">
        <h1>Users manager</h1>
        <br>
        <a href="home.php">< Back</a>
        <br>
        <br>
        <form method="post" action="updateUser.php">
            <table width="500px">
                <?php
                if (isset($error) && $error) {
                    echo '<tr>
                        <td colspan="2" align="center" style="color:red; font-weight:bold">
                        Incorrect confirm password
                        </td>
                        </tr>';
                }
                ?>
                <tr>
                    <td colspan="2">
                        <br>
                    </td>
                </tr>
                <tr align="left">
                    <th>
                        Username
                    </th>
                    <td>
                        <input type="text" name="username" size="50" minlength="1" maxlength="50" <?php echo $valueUsername; echo $styleUsername; ?> required>
                    </td>
                </tr>
                <tr align="left">
                    <th>
                        Password
                    </th>
                    <td>
                        <input type="password" name="password" size="50" minlength="8" maxlength="50">
                    </td>
                </tr>
                <tr align="left">
                    <th>
                        Confirm Password
                    </th>
                    <td>
                        <input type="password" name="confirmPassword" size="50" minlength="8" maxlength="50">
                    </td>
                </tr>
                <tr align="left">
                    <th>
                        Active
                    </th>
                    <td>
                        <input type="checkbox" name="active" value="1" <?php echo $activeChecked?>><br>
                    </td>
                </tr>
                <tr align="left">
                    <th>
                        Type of account
                    </th>
                    <td>
                        <input type="radio" name="role" value="1" <?php echo $roleAdministrator; ?> required>Administrator<br>
                        <input type="radio" name="role" value="2" <?php echo $roleCoWorker; ?> required>Co-worker<br>
                    </td>
                </tr>
                <tr>
                    <td align="right" colspan="2">
                        <input type="submit" value="Done">
                    </td>
                </tr>
            </table>
        </form>
    </body>
</html>

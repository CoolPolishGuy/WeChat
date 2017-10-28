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
require_once('Mail.php');
require_once('User.php');

// Redirige l'utilisateur vers index.php
Authentication::getInstance()->goToLocation(Authentication::getInstance()->isNotLogged());

$idMail = '';
$valueFrom = 'value="'.User::getInstance()->getUsername()->fetch()['username'].'"';
$styleFrom = 'style="border:none" readonly ';
$valueTo = '';
$valueSubject = '';
$styleOthers = '';

// Si c'est la réponse à un email
if (isset($id)) {
    $idMail = "?id={$id}";    
    $valueTo = 'value="'.Mail::getInstance()->getTo($id)->fetch()['to'].'"';
    $valueSubject = 'value="RE: '.Mail::getInstance()->getSubject($id)->fetch()['subject'].'"';
    $styleOthers = 'style="border:none" readonly ';
}

// Ferme la connexion à la base de données
Database::getInstance()->deconnection();
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
    <head>
        <title>WeChat - Write a mail</title>
        <meta http-equiv="content-type" content="text/html; charset=utf-8"/>
    </head>
    <body style="background-image: url(./images/background.jpg)">
        <h1>Write a mail</h1>
        <br>
        <a href="home.php">< Back</a>
        <br>
        <br>
        <form method="post" action="sendMail.php<?php echo $idMail; ?>">
            <table width="500px">
                <?php
                if (isset($error) && $error) {
                    echo '<tr>
                        <td colspan="2" align="center" style="color:red; font-weight:bold">
                        Unknown username
                        </td>
                        </tr>';
                }
                ?>
                <tr align="right">
                    <td colspan="2">
                        <input type="submit" value="Send">
                    </td>
                </tr>
                <tr align="left">
                    <th width="100px">
                        From
                    </th>
                    <td>
                        <input type="text" name="from" size="51" maxlength="50" <?php echo $valueFrom; echo $styleFrom; ?>required>
                    </td>
                </tr>
                <tr align="left">
                    <th>
                        To
                    </th>
                    <td>
                        <input type="text" name="to" size="51" maxlength="50" <?php echo $valueTo; echo $styleOthers; ?>required>
                    </td>
                </tr>
                <tr align="left">
                    <th>
                        Subject
                    </th>
                    <td>
                        <input type="text" name="subject" size="51" maxlength="50" <?php echo $valueSubject; echo $styleOthers; ?>required>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <br>
                    </td>
                </tr>
                <tr align="left">
                    <th colspan="2">
                        Mail Body
                    </th>
                </tr>
                <tr>
                    <td>
                    </td>
                    <td>
                        <textarea name="body" cols="52" rows="20" maxlength="1000" style="resize: none;" required></textarea>
                    </td>
                </tr>
            </table>
        </form>
    </body>
</html>

<?php
/**
 * STI - Project Web
 * WeChat
 * Description: web site to send mails between users 
 * Authors: Loan Lassalle, Wojciech Myszkorowski
 */

// Paramètre de la zone du temps
date_default_timezone_set('Europe/Zurich');

require_once('Database.php');
require_once('Mail.php');
require_once('Role.php');
require_once('User.php');

/**
 * Crée les tables
 */

Database::getInstance()->query('CREATE TABLE IF NOT EXISTS roles (
                                id INTEGER PRIMARY KEY AUTOINCREMENT, 
                                name VARCHAR(255) UNIQUE NOT NULL);');
                
Database::getInstance()->query('CREATE TABLE IF NOT EXISTS users (
                                id INTEGER PRIMARY KEY AUTOINCREMENT,
                                username VARCHAR(255) UNIQUE NOT NULL,
                                salt VARCHAR(255) NOT NULL,
                                digest VARCHAR(88) UNIQUE NOT NULL,
                                active INTEGER NOT NULL,
                                role INTEGER NOT NULL,
                                FOREIGN KEY(role) REFERENCES roles(id));');
                
Database::getInstance()->query('CREATE TABLE IF NOT EXISTS mails (
                                id INTEGER PRIMARY KEY AUTOINCREMENT,
                                date VARCHAR(23) UNIQUE NOT NULL,
                                idSender INTEGER,
                                idReceiver INTEGER,
                                subject VARCHAR(255) NOT NULL,
                                body TEXT(1024) NOT NULL,
                                FOREIGN KEY(idSender) REFERENCES users(id),
                                FOREIGN KEY(idReceiver) REFERENCES users(id));'); 

/**
 * Paramètre les données
 */

$roles = array(
            array('name' => 'Administrator'),
            array('name' => 'Co-worker')
            );
            
$users = array(
            array('username' => 'root',
                'password' => 'toortoor',
                'active' => '1',
                'role' => '1'),
            array('username' => 'toor',
                'password' => 'rootroot',
                'active' => '0',
                'role' => '1'),
            array('username' => 'loan',
                'password' => '12341234',
                'active' => '1',
                'role' => '2'),
            array('username' => 'wojciech',
                'password' => '45674567',
                'active' => '1',
                'role' => '2'),
            array('username' => 'tano',
                'password' => '78907890',
                'active' => '0',
                'role' => '2')
            );
            
$mails = array(
            array('date' => '2017-07-25T16:47:33.698',
                'idSender' => '3',
                'idReceiver' => '4',
                'subject' => 'CTF to Bucarest !',
                'body' => 'Hi Wojciech, are you ? Are you ready to go to Bucarest ? I can not wait !! Take care.'),
            array('date' => '2017-08-09T10:14:23.698',
                'idSender' => '4',
                'idReceiver' => '3',
                'subject' => 'RE: CTF to Bucarest !',
                'body' => 'Hello Loan ! Yes ! I am ready to go !! Do you prefer to go by plane, train or car? Because my father offers us to take the private jet !'),
            array('date' => '2017-08-14T22:37:43.698',
                'idSender' => '5',
                'idReceiver' => '2',
                'subject' => 'Hints for Labo_01',
                'body' => 'Can you tell me the answer of the first question please.'),
            array('date' => '2017-08-25T12:12:38.388',
                'idSender' => '1',
                'idReceiver' => '3',
                'subject' => 'Welcome !',
                'body' => 'Welcome to WeChat, the net social plateform. Enjoy !'),
            array('date' => '2017-08-25T16:16:39.798',
                'idSender' => '1',
                'idReceiver' => '4',
                'subject' => 'Welcome !',
                'body' => 'Welcome to WeChat, the net social plateform. Enjoy !'),
            array('date' => '2017-09-01T18:49:38.698',
                'idSender' => '1',
                'idReceiver' => '5',
                'subject' => 'Welcome !',
                'body' => 'Welcome to WeChat, the net social plateform. Enjoy !'),
            array('date' => '2017-09-08T21:57:38.698',
                'idSender' => '2',
                'idReceiver' => '4',
                'subject' => 'Protect your password',
                'body' => 'Welcome to WeChat, the net social plateform. Enjoy !'),
            array('date' => '2017-09-22T23:36:38.698',
                'idSender' => '3',
                'idReceiver' => '4',
                'subject' => 'RE: CTF to Bucarest !',
                'body' => 'the PRIVATE JET !!!'),
            array('date' => '2017-10-03T07:36:38.698',
                'idSender' => '3',
                'idReceiver' => '1',
                'subject' => 'Administration of website ',
                'body' => 'Can I join administration of the website ?'),
            array('date' => '2017-10-03T10:36:38.698',
                'idSender' => '3',
                'idReceiver' => '1',
                'subject' => 'Pentesting',
                'body' => 'You should think about doing pentest. Because your website is under attack.')
            );

/**
 * Insert les données
 */

Role::getInstance()->insertMultiple($roles);
User::getInstance()->insertMultiple($users);
Mail::getInstance()->insertMultiple($mails);

/**
 * Ferme la connexion à la base de données
 */
Database::getInstance()->deconnection();

/**
 * Affiche les données
 */
header('location:showData.php');
?>


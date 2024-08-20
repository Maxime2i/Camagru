<?php

const DBHOST = '127.0.0.1';  // Remplacé 'localhost' par '127.0.0.1'
const DBUSER = 'user';       // Assurez-vous que ce nom d'utilisateur existe dans MySQL
const DBPASS = 'pass';       // Le mot de passe pour l'utilisateur MySQL
const DBNAME = 'camagru';
const DBPORT = '3306';      // Port exposé par MySQL dans Docker

$dsn = 'mysql:host=' . DBHOST . ';port=' . DBPORT . ';dbname=' . DBNAME;

try {
    $pdo = new PDO($dsn, DBUSER, DBPASS);
    echo 'Connexion réussie';
} catch (PDOException $e) {
    echo 'Erreur aaa: ' . $e->getMessage();
    die();
}
?>
test
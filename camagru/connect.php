<?php

const DBHOST = '127.0.0.1';
const DBUSER = getenv('MYSQL_USER') ?: 'user';
const DBPASS = getenv('MYSQL_PASSWORD') ?: 'pass';
const DBNAME = getenv('MYSQL_DATABASE') ?: 'camagru';
const DBPORT = '3306';

$dsn = 'mysql:host=' . DBHOST . ';port=' . DBPORT . ';dbname=' . DBNAME;
echo $dsn;

try {
    $pdo = new PDO($dsn, DBUSER, DBPASS);
    echo 'Connexion réussie';
} catch (PDOException $e) {
    echo 'Erreur aaa: ' . $e->getMessage();
    die();
}
?>

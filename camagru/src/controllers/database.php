<?php

$servername = "mysql";
$username = "user";
$password = "password";
$dbname = "camagru";

try {

    $connexion = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    
    $sql = "CREATE TABLE IF NOT EXISTS users (
        id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        firstname VARCHAR(30) NOT NULL,
        lastname VARCHAR(30) NOT NULL,
        username VARCHAR(30) NOT NULL,
        email VARCHAR(100) NOT NULL, 
        pass VARCHAR(100) NOT NULL
    )";

    $connexion->exec($sql);



} catch (PDOException $e) {

    echo "Error: " . $e->getMessage();
    die();
}

try {
    $connexion = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    
    $sql = "CREATE TABLE IF NOT EXISTS gallery (
        img_id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        img_taille VARCHAR( 25 ) NOT NULL ,
        img_type VARCHAR( 25 ) NOT NULL ,
        img_blob LONGBLOB NOT NULL ,
        user_id INT(6) UNSIGNED,
        FOREIGN KEY (user_id) REFERENCES users(id)
    )";

    $connexion->exec($sql);
    
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
    die();
}
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
        pass VARCHAR(100) NOT NULL,
        token VARCHAR(100) NOT NULL,
        is_verified BOOLEAN DEFAULT 0,
    )";

    $connexion->exec($sql);



} catch (PDOException $e) {

    echo "Error: " . $e->getMessage();
    die();
}

try {
    $connexion = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    
    $sql = "CREATE TABLE IF NOT EXISTS gallery (
        id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        img VARCHAR(100) NOT NULL,
        user_id INT(6) UNSIGNED, 
        liked_by VARCHAR(100),
        nb_like INT(6) UNSIGNED, 
        FOREIGN KEY (user_id) REFERENCES users(id)
       
    )";

    $connexion->exec($sql);


    
    $sql = "CREATE TABLE IF NOT EXISTS comments (
        id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        gallery_id INT(6) UNSIGNED,
        user_id INT(6) UNSIGNED,
        comment TEXT,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (gallery_id) REFERENCES gallery(id),
        FOREIGN KEY (user_id) REFERENCES users(id)
    )";

    $connexion->exec($sql);
    
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
    die();
}
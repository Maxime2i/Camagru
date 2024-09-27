<?php

$servername = "mysql";
$username = "user";
$password = "password";
$dbname = "camagru";

try {
    // Créer une nouvelle connexion PDO
    $connexion = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Créer la table users
    $sql = "CREATE TABLE IF NOT EXISTS users (
        id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        firstname VARCHAR(30) NOT NULL,
        lastname VARCHAR(30) NOT NULL,
        username VARCHAR(30) NOT NULL,
        email VARCHAR(100) NOT NULL, 
        pass VARCHAR(100) NOT NULL,
        token VARCHAR(100) NOT NULL,
        is_verified BOOLEAN DEFAULT 0,
        mail_notification BOOLEAN DEFAULT 0
    )";
    $connexion->exec($sql);
    //echo "Table 'users' créée avec succès.<br>";

    // Créer la table gallery
    $sql = "CREATE TABLE IF NOT EXISTS gallery (
        id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        img VARCHAR(100) NOT NULL,
        user_id INT(6) UNSIGNED, 
        liked_by JSON,
        nb_like INT(6) UNSIGNED, 
        description TEXT,
        FOREIGN KEY (user_id) REFERENCES users(id)
    )";
    $connexion->exec($sql);
    //echo "Table 'gallery' créée avec succès.<br>";

    // Créer la table comments
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
    //echo "Table 'comments' créée avec succès.<br>";

} catch (PDOException $e) {
    echo "Erreur : " . $e->getMessage();
    die();
}

?>

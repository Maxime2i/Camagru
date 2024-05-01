<?php
// Vérifie si des données d'image ont été envoyées
include 'src/controllers/database.php';
if(isset($_POST['imageData'])) {
    // Se connecter à votre base de données
    $servername = "mysql";
    $username = "user";
    $password = "password";
    $dbname = "camagru";

    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Préparez la requête SQL pour insérer les données de l'image dans la base de données
    $stmt = $conn->prepare("INSERT INTO gallery (img_taille, img_type, img_blob, user_id) VALUES (:taille, :type, :blob, :userId)");

    // Liage des valeurs avec les paramètres de la requête
    $stmt->bindParam(':taille', $_POST['taille']);
    $stmt->bindParam(':type', $_POST['type']);
    $stmt->bindParam(':blob', $_POST['imageData']);
    $stmt->bindParam(':userId', $_POST['userId']);

    // Exécutez la requête
    $stmt->execute();

    // Fermez la connexion à la base de données
    $conn = null;
} else {
    echo "Aucune donnée d'image n'a été reçue.";
}



?>
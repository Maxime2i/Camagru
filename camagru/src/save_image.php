<?php
include 'controllers/database.php';
session_start();

if (isset($_POST['image']) && isset($_POST['filtered_image'])) {
    $data_fond = $_POST['image'];
    $data_fond = str_replace('data:image/png;base64,', '', $data_fond);
    $data_fond = str_replace(' ', '+', $data_fond);
    $imageDataFond = base64_decode($data_fond);
    
    $data_superposee = $_POST['filtered_image'];
    $data_superposee = str_replace('data:image/png;base64,', '', $data_superposee);
    $data_superposee = str_replace(' ', '+', $data_superposee);
    $imageDataSuperposee = base64_decode($data_superposee);
    
    // Charger l'image de fond
    $image_fond = imagecreatefromstring($imageDataFond);
    
    // Charger l'image à superposer
    $image_superposee = imagecreatefromstring($imageDataSuperposee);
    
    // Superposer l'image à superposer sur l'image de fond
    $x = 0; // Position horizontale de l'image superposée sur l'image de fond
    $y = 0; // Position verticale de l'image superposée sur l'image de fond
    imagecopy($image_fond, $image_superposee, $x, $y, 0, 0, imagesx($image_superposee), imagesy($image_superposee));

    // Nom de fichier unique
    $fileName = 'superposed_image_' . uniqid() . '.png';
    
    // Enregistrement de l'image superposée sur le serveur
    imagepng($image_fond, 'uploads/' . $fileName);

    // Libérer la mémoire
    imagedestroy($image_fond);
    imagedestroy($image_superposee);

    // Insertion dans la base de données
    $user_id = $_SESSION['user_id'];
    $requete = $connexion->prepare("INSERT INTO gallery VALUES (0, :img, :user_id)");
    $requete->execute(
        array(
            "img" => $fileName,
            "user_id" => $user_id,
        )
    );

    echo $fileName; // Envoyer le nom du fichier superposé au client
} else {
    echo 'No image data received';
}

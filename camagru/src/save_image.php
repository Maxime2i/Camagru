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

    $filterTop = $_POST['filter_top'];
    $filterLeft = $_POST['filter_left'];
    $filterWidth = $_POST['filter_width'];
    $filterHeight = $_POST['filter_height'];
    
    // Charger l'image de fond
    $image_fond = imagecreatefromstring($imageDataFond);
    
    // Charger l'image à superposer
    $image_superposee = imagecreatefromstring($imageDataSuperposee);
    
    // Superposer l'image à superposer sur l'image de fond
    $x = 0; // Position horizontale de l'image superposée sur l'image de fond
    $y = 0; // Position verticale de l'image superposée sur l'image de fond


    $resized_filter_image = imagecreatetruecolor($filterWidth, $filterHeight);
    imagealphablending($resized_filter_image, false);
    imagesavealpha($resized_filter_image, true);
    imagecopyresampled($resized_filter_image, $image_superposee, 0, 0, 0, 0, $filterWidth, $filterHeight, imagesx($image_superposee), imagesy($image_superposee));



    imagecopy($image_fond, $resized_filter_image, $filterLeft, $filterTop, 0, 0, $filterWidth, $filterHeight);

    // Nom de fichier unique
    $fileName = 'superposed_image_' . uniqid() . '.png';
    
    // Enregistrement de l'image superposée sur le serveur
    imagepng($image_fond, 'uploads/' . $fileName);

    // Libérer la mémoire
    imagedestroy($image_fond);
    imagedestroy($image_superposee);

    // Insertion dans la base de données
    $user_id = $_SESSION['user_id'];
    $requete = $connexion->prepare("INSERT INTO gallery VALUES (0, :img, :user_id, :liked_by, :nb_like)");
    $requete->execute(
        array(
            "img" => $fileName,
            "user_id" => $user_id,
            "liked_by" => '',
            "nb_like" => 0,
        )
    );

    echo $fileName; // Envoyer le nom du fichier superposé au client
} else {
    echo 'No image data received';
}

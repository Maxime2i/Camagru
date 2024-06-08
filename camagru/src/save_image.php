<?php
include 'controllers/database.php';
session_start();

if (isset($_POST['image']) && isset($_POST['filter_image_url'])) {
    $data_fond = $_POST['image'];
    $data_fond = str_replace('data:image/png;base64,', '', $data_fond);
    $data_fond = str_replace(' ', '+', $data_fond);
    $imageDataFond = base64_decode($data_fond);

    $filter_image_url = $_POST['filter_image_url'];
    
    // Charger l'image de fond
    $image_fond = imagecreatefromstring($imageDataFond);

    if ($filter_image_url !== '') {
        // Charger l'image du filtre à partir de l'URL
        $image_superposee = imagecreatefrompng($filter_image_url);

        // Redimensionner l'image superposée pour qu'elle ait la même taille que l'image de fond
        $new_width = imagesx($image_fond);
        $new_height = imagesy($image_fond);

        $resized_superposee = imagescale($image_superposee, $new_width, $new_height, IMG_BILINEAR_FIXED);

        // Superposer l'image redimensionnée sur l'image de fond
        $x = 0; // Position horizontale de l'image superposée sur l'image de fond
        $y = 0; // Position verticale de l'image superposée sur l'image de fond
        imagecopy($image_fond, $resized_superposee, $x, $y, 0, 0, $new_width, $new_height);

        // Libérer la mémoire
        imagedestroy($image_superposee);
        imagedestroy($resized_superposee);
    }

    // Nom de fichier unique
    $fileName = 'superposed_image_' . uniqid() . '.png';
    
    // Enregistrement de l'image superposée sur le serveur
    imagepng($image_fond, 'uploads/' . $fileName);

    // Libérer la mémoire
    imagedestroy($image_fond);

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
?>

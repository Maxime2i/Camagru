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

        // Redimensionner l'image superposée en préservant la transparence
        $new_width = 100;  // Nouvelle largeur de l'image superposée
        $new_height = 100; // Nouvelle hauteur de l'image superposée

        // Créer une nouvelle image avec des dimensions spécifiques et préserver la transparence
        $image_superposee_resized = imagecreatetruecolor($new_width, $new_height);
        imagealphablending($image_superposee_resized, false);
        imagesavealpha($image_superposee_resized, true);
        $transparent = imagecolorallocatealpha($image_superposee_resized, 0, 0, 0, 127);
        imagefill($image_superposee_resized, 0, 0, $transparent);

        // Copier et redimensionner l'image superposée d'origine dans la nouvelle image vide
        imagecopyresampled($image_superposee_resized, $image_superposee, 0, 0, 0, 0, $new_width, $new_height, imagesx($image_superposee), imagesy($image_superposee));

        // Superposer l'image redimensionnée sur l'image de fond
        $x = 0; // Position horizontale de l'image superposée sur l'image de fond
        $y = 50; // Position verticale de l'image superposée sur l'image de fond
        imagecopy($image_fond, $image_superposee_resized, $x, $y, 0, 0, $new_width, $new_height);

        // Libérer la mémoire
        imagedestroy($image_superposee);
        imagedestroy($image_superposee_resized);
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

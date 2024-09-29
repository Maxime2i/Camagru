<?php
include 'controllers/database.php';
session_start();

if (isset($_POST['image']) && isset($_POST['filter_image_url'])) {
    $data_fond = $_POST['image'];
    $data_fond = str_replace('data:image/png;base64,', '', $data_fond);
    $data_fond = str_replace(' ', '+', $data_fond);
    $imageDataFond = base64_decode($data_fond);

    $filter_image_url = $_POST['filter_image_url'];
    
    $image_fond = imagecreatefromstring($imageDataFond);

    if ($filter_image_url !== '') {
        $image_superposee = imagecreatefrompng($filter_image_url);

        $new_width = imagesx($image_fond);
        $new_height = imagesy($image_fond);

        $resized_superposee = imagescale($image_superposee, $new_width, $new_height, IMG_BILINEAR_FIXED);

        $x = 0; 
        $y = 0; 
        imagecopy($image_fond, $resized_superposee, $x, $y, 0, 0, $new_width, $new_height);

        imagedestroy($image_superposee);
        imagedestroy($resized_superposee);
    }

    $fileName = 'superposed_image_' . uniqid() . '.png';
    
    imagepng($image_fond, 'uploads/' . $fileName);

    imagedestroy($image_fond);

    $user_id = $_SESSION['user_id'];
    $requete = $connexion->prepare("INSERT INTO gallery (img, user_id, liked_by, nb_like, description) VALUES (:img, :user_id, :liked_by, :nb_like, :description)");
    $requete->execute(
        array(
            "img" => $fileName,
            "user_id" => $user_id,
            "liked_by" => json_encode(array()),
            "nb_like" => 0,
            "description" => ''
        )
    );

    $image_id = $connexion->lastInsertId();

    if (true){  
        echo json_encode(['success' => true, 'image_id' => $image_id]);
    } else {
        echo json_encode(['success' => false, 'error' => 'Échec de l\'insertion dans la base de données']);
    }
    
} else {
    echo json_encode(array("error" => "No image data received"));
}
?>

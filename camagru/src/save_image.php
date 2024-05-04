<?php
include 'controllers/database.php';
if (isset($_POST['image'])) {
    $data = $_POST['image'];
    $data = str_replace('data:image/png;base64,', '', $data);
    $data = str_replace(' ', '+', $data);
    $imageData = base64_decode($data);
    
    // Nom de fichier unique
    $fileName = 'webcam_image_' . uniqid() . '.png';
    
    // Enregistrement de l'image sur le serveur
    file_put_contents('uploads/' . $fileName, $imageData);
    
    echo $fileName;

    $user_id = 1;

    $requete = $connexion->prepare("INSERT INTO gallery VALUES (0, :img, :user_id)");
    $requete->execute(
        array(
            "img" => $fileName,
            "user_id" => $user_id,
        )
    );

} else {
    echo 'No image data received';
}
?>
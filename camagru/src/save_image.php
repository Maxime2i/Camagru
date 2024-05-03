<?php
if(isset($_POST['image'])) {
    $img = $_POST['image'];
    $img = str_replace('data:image/jpeg;base64,', '', $img);
    $img = str_replace(' ', '+', $img);
    $data = base64_decode($img);

    // Chemin de sauvegarde de l'image
    $file = '/var/www/camagru/uploads/' . uniqid() . '.jpg';

    // Enregistrement de l'image sur le serveur
    file_put_contents($file, $data);
}
?>
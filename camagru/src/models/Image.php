<?php

class ImageModel {
    public static function getImageUrlById($imageId) {
        include 'src/controllers/database.php';

        $requete = $connexion->prepare("SELECT * FROM gallery WHERE id = :id");
        $requete->execute(array(':id' => $imageId));
        $image = $requete->fetch();

        return 'src/uploads/' . $image['img'];
    }
}
?>
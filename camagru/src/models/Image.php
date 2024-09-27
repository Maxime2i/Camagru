<?php

class ImageModel {
    public static function getImageUrlById($imageId) {
        include 'src/controllers/database.php';

        $requete = $connexion->prepare("SELECT * FROM gallery WHERE id = :id");
        $requete->execute(array(':id' => $imageId));
        $image = $requete->fetch();

        return $image['img'];
    }

    public static function getImageByUrl($imageUrl) {
        include 'src/controllers/database.php';

        $requete = $connexion->prepare("SELECT id FROM gallery WHERE img = :img AND user_id = :user_id");
        $requete->execute(array(':img' => basename($imageUrl), ':user_id' => $userId));
        $image = $requete->fetch();

        return $image;
    }

    public static function updateImageDescription($imageId, $description) {
        include 'src/controllers/database.php';

        $requete = $connexion->prepare("UPDATE gallery SET description = :description WHERE id = :id");
        $requete->execute(array(':description' => $description, ':id' => $imageId));
    }

    public static function deleteImage($imageUrl, $userId) {
        include 'src/controllers/database.php';

        $requete = $connexion->prepare("DELETE FROM gallery WHERE img = :img AND user_id = :user_id");
        $resultat = $requete->execute(array(':img' => basename($imageUrl), ':user_id' => $userId));
    }

}
?>
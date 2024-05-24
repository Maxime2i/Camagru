<?php

class GalleryModel {
    public static function getAllImages() {
        include "src/controllers/database.php";
        
        $requete = $connexion->prepare('SELECT * FROM gallery');
        $requete->execute();
        return $requete->fetchAll();
    }

    public static function getImagesByPage($start, $limit) {
        include "src/controllers/database.php";

        $requete = $connexion->prepare("SELECT * FROM gallery ORDER BY id DESC LIMIT :start, :limit");
        $requete->bindParam(':start', $start, PDO::PARAM_INT);
        $requete->bindParam(':limit', $limit, PDO::PARAM_INT);
        $requete->execute();
        $images = $requete->fetchAll(PDO::FETCH_ASSOC);
        return $images;
    }

    public static function getTotalImagesCount() {
        include "src/controllers/database.php";

        $requete = $connexion->query("SELECT COUNT(*) AS total FROM gallery");
        $result = $requete->fetch(PDO::FETCH_ASSOC);
        return $result['total'];
    }

    public static function getUsername($user_id) {
        include "src/controllers/database.php";
        
        $requete_user = $connexion->prepare('SELECT username FROM users WHERE id = :user_id');
        $requete_user->execute(array('user_id' => $user_id));
        $user = $requete_user->fetch();
        return $user['username'];
    }
}

?>

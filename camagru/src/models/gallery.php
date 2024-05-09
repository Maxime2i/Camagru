<?php

class GalleryModel {
    public static function getAllImages() {
        include "src/controllers/database.php";
        
        $requete = $connexion->prepare('SELECT * FROM gallery');
        $requete->execute();
        return $requete->fetchAll();
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

<?php

class HomepageModel {
    public static function getImages() {
        include "src/controllers/database.php";
        
        $requete = $connexion->prepare('SELECT * FROM gallery ORDER BY id DESC LIMIT 5');
        $requete->execute();

        $images = $requete->fetchAll();

        foreach ($images as &$image) {
            $requeteAuteur = $connexion->prepare('SELECT username FROM users WHERE id = :user_id');
            $requeteAuteur->execute(['user_id' => $image['user_id']]);
            $auteur = $requeteAuteur->fetch(PDO::FETCH_ASSOC);
            $image['author'] = $auteur['username'];
        }

        return $images;
    }
   
}

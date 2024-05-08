<?php

class GalleryController {
    public function index() {
        include "src/controllers/database.php";
       

        
        $requete = $connexion->prepare('SELECT * FROM gallery');
        $requete->execute();
        $images = $requete->fetchAll();
        
        // Récupérer les noms d'utilisateur associés à chaque image
        $usernames = [];
        foreach ($images as $image) {
            $requete_user = $connexion->prepare('SELECT username FROM users WHERE id = :user_id');
            $requete_user->execute(array('user_id' => $image['user_id']));
            $user = $requete_user->fetch();
            $usernames[$image['user_id']] = $user['username'];
        }
        
        // Inclure la vue
        include 'src/views/gallery.php';
        
    }




}

?>
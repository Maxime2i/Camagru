<?php

class GalleryController {
    public function index() {
        include "src/controllers/database.php";
        include 'src/views/gallery.php';

        
        $reponse = $connexion->query('SELECT * FROM gallery');
        while ($donnees = $reponse->fetch()){
                // Afficher chaque photo
                echo '<img src="src/uploads/' . $donnees["img"] . '" alt="' . $donnees["user_id"] . '"><br>';
            }
        
    }




}

?>
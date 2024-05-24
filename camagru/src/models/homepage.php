<?php

class HomepageModel {
    public static function getImages() {
        include "src/controllers/database.php";
        
        $requete = $connexion->prepare('SELECT * FROM gallery ORDER BY id DESC LIMIT 5');
        $requete->execute();
        return $requete->fetchAll();
    }
   
}

<?php

class MontageModel {
    public static function getRecentImages() {
        include "src/controllers/database.php";
        
        $requete = $connexion->prepare('SELECT * FROM gallery ORDER BY id DESC LIMIT 10');
        $requete->execute(array());
        return $requete->fetchAll();
    }

   
    
}

?>

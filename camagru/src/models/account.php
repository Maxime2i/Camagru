<?php

class AccountModel {
    public static function getMyImages($user_id) {
        include "src/controllers/database.php";
        
        $requete = $connexion->prepare('SELECT * FROM gallery WHERE user_id = :user_id');
        $requete->execute(array('user_id' => $user_id));
        return $requete->fetchAll();
    }
    
}

?>

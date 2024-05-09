<?php

class AccountModel {
    public static function getMyImages($user_id) {
        include "src/controllers/database.php";
        
        $requete = $connexion->prepare('SELECT * FROM gallery WHERE user_id = :user_id');
        $requete->execute(array('user_id' => $user_id));
        return $requete->fetchAll();
    }

    public static function updateUserInfo($Username, $email, $Password) {
        include "src/controllers/database.php";
        
        try {
            // Préparez et exécutez la requête SQL pour mettre à jour les informations de l'utilisateur
            $query = "UPDATE users SET username = :username, email = :email, pass = :password WHERE id = :user_id";
            $statement = $connexion->prepare($query);
            $statement->execute(array(
                'username' => $Username,
                'email' => $email,
                'password' => $Password, // Remarque: vous devez hasher le mot de passe avant de le stocker dans la base de données pour des raisons de sécurité
                'user_id' => $_SESSION['user_id'] // Vous devez récupérer l'ID de l'utilisateur connecté à partir de la session
            ));

            // Retourne true si la mise à jour a réussi
            return true;
        } catch (PDOException $e) {
            // Gérez les exceptions PDO ici
            // Par exemple, journalisez l'erreur ou renvoyez false en cas d'échec
            return false;
        }
    }
    
}

?>

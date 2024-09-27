<?php

class LoginModel {
    public static function getUserByUsername($Username) {
        include 'src/controllers/database.php';

        $requete = $connexion->prepare("SELECT * FROM users WHERE username = :username");
        $requete->execute(array(':username' => $Username));
        $user = $requete->fetch();

        return $user;
    }

    public static function getUserByEmail($email) {
        include 'src/controllers/database.php';

        $requete = $connexion->prepare("SELECT * FROM users WHERE email = :email");
        $requete->execute(array(':email' => $email));
        $user = $requete->fetch();

        return $user;
    }

    public static function getUserById($id) {
        include 'src/controllers/database.php';

        $requete = $connexion->prepare("SELECT * FROM users WHERE id = :id");
        $requete->execute(array(':id' => $id));
        $user = $requete->fetch();

        return $user;
    }

    public static function updateTokenById($id) {
        include 'src/controllers/database.php';

        $token = bin2hex(random_bytes(16));

        $requete = $connexion->prepare("UPDATE users SET token = :token WHERE id = :id");
        $requete->execute(array(':token' => $token, ':id' => $id));

        return $token;
    }

    public static function updateTokenByEmail($email) {
        include "src/controllers/database.php";

        $token = bin2hex(random_bytes(16));
            
        $update = $connexion->prepare("UPDATE users SET token = :token WHERE email = :email");
        $update->execute([
            'token' => $token,
            'email' => $email
        ]);

        return $token;
    }

}

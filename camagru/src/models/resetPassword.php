<?php

class ResetPasswordModel {
    public static function getUserByIdAndToken($id, $token) {
        include "src/controllers/database.php";

        $requete = $connexion->prepare("SELECT * FROM users WHERE id = :id AND token = :token");
        $requete->execute(array(
            "id" => $id,
            "token" => $token
        ));
        $user = $requete->fetch();

        return $user;
    }

    public static function updatePassword($Password, $id) {
        include "src/controllers/database.php";

        $update = $connexion->prepare("UPDATE users SET pass = :password WHERE id = :id");
        $update->execute(array(
            "password" => $Password,
            "id" => $id
        ));

        return true;
    }

    public static function updateToken($id) {
        include "src/controllers/database.php";
        $token = bin2hex(random_bytes(16));

        $update = $connexion->prepare("UPDATE users SET token = :token WHERE id = :id");
        $update->execute(array(
            "token" => $token,
            "id" => $id
        ));
    }
}
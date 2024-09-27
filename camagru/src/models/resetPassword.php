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

    public static function updatePassword($password, $id) {
        include "src/controllers/database.php";

        $update = $connexion->prepare("UPDATE users SET pass = :password WHERE id = :id");
        $update->execute(array(
            "password" => $password,
            "id" => $id
        ));

        return true;
    }
}
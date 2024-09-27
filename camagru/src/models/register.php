<?php

class RegisterModel {
    public static function isUsernameAlreadyTake($username) {
        include "src/controllers/database.php";

        $checkUsername = $connexion->prepare("SELECT COUNT(*) FROM users WHERE username = :username");
        $checkUsername->execute(["username" => $username]);
        $usernameExists = $checkUsername->fetchColumn();

        if ($usernameExists){
            return true;
        }
        else {
            return false;
        }
    }

    public static function isEmailAlreadyTake($email) {
        include "src/controllers/database.php";

        $checkEmail = $connexion->prepare("SELECT COUNT(*) FROM users WHERE email = :email");
        $checkEmail->execute(["email" => $email]);
        $emailExists = $checkEmail->fetchColumn();

        if ($emailExists){
            return true;
        }
        else {
            return false;
        }
    }

    public static function createAccount($firstname, $lastname, $username, $email, $password){
        include "src/controllers/database.php";

        $token = bin2hex(random_bytes(16));

        $requete = $connexion->prepare("INSERT INTO users VALUES (0, :firstname, :lastname, :username, :email, :pass, :token, :isVerified, :mail_notification)");
        $requete->execute(
            array(
                "firstname" => $firstname,
                "lastname" => $lastname,
                "username" => $username,
                "email" => $email,
                "pass" => $password,
                "token" => $token,
                "isVerified" => 0,
                "mail_notification" => 1
            )
        );

        return $token;
    }

}
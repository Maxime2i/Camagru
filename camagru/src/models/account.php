<?php

class AccountModel {
    public static function getMyImages($user_id) {
        include "src/controllers/database.php";
        
        $requete = $connexion->prepare('SELECT * FROM gallery WHERE user_id = :user_id ORDER BY id DESC');
        $requete->execute(array('user_id' => $user_id));
        return $requete->fetchAll();
    }

    public static function getMailNotification($user_id) {
        include "src/controllers/database.php";

        $requete = $connexion->prepare('SELECT mail_notification FROM users WHERE id = :user_id');
        $requete->execute(array('user_id' => $user_id));
        $result = $requete->fetch();
        return $result['mail_notification'];
    }

    public static function updateUserInfo($Username, $email, $mail_notification, $Password) {
        include "src/controllers/database.php";
        
        try {
            $query = "UPDATE users SET username = :username, email = :email, pass = :pass, mail_notification = :mail_notification WHERE id = :user_id";
            $statement = $connexion->prepare($query);
            $statement->execute(array(
                'username' => $Username,
                'email' => $email,
                'user_id' => $_SESSION['user_id'], 
                'mail_notification' => $mail_notification,
                'pass' => $Password
            ));
            return true;
        } catch (PDOException $e) {
            return false;
        }
    }


    public static function updateUserInfoWithoutPassword($Username, $email, $mail_notification) {
        include "src/controllers/database.php";
        
        try {
            $query = "UPDATE users SET username = :username, email = :email, mail_notification = :mail_notification WHERE id = :user_id";
            $statement = $connexion->prepare($query);
            $statement->execute(array(
                'username' => $Username,
                'email' => $email,
                'user_id' => $_SESSION['user_id'], 
                'mail_notification' => $mail_notification,

            ));
            return true;
        } catch (PDOException $e) {
            return false;
        }
    }



    public static function confirmUserAccount($email, $token) {
        include "src/controllers/database.php";

        try {
            $requete = $connexion->prepare("SELECT * FROM users WHERE email = :email AND token = :token");
            $requete->execute(array("email" => $email, "token" => $token));
            return $requete->fetch();
        } catch (PDOException $e) {
            throw new Exception("Erreur lors de la vérification de l'utilisateur : " . $e->getMessage());
        }
    }

    public static function verifyUser($email) {
        include "src/controllers/database.php";

        try {
            $update = $connexion->prepare("UPDATE users SET is_verified = true WHERE email = :email");
            $update->execute(array("email" => $email));
        } catch (PDOException $e) {
            throw new Exception("Erreur lors de la mise à jour de l'utilisateur : " . $e->getMessage());
        }
    }

    public static function deleteImage($image_id, $user_id) {
        include "src/controllers/database.php";

        try {
            $connexion->beginTransaction();

            $deleteComments = $connexion->prepare("DELETE FROM comments WHERE gallery_id = :image_id");
            $deleteComments->execute(array("image_id" => $image_id));

            $query = $connexion->prepare("SELECT img FROM gallery WHERE id = :image_id AND user_id = :user_id");
            $query->execute(array("image_id" => $image_id, "user_id" => $user_id));
            $result = $query->fetch(PDO::FETCH_ASSOC);

            if ($result) {
                $image_path = $result['img'];

                $delete = $connexion->prepare("DELETE FROM gallery WHERE id = :image_id AND user_id = :user_id");
                $delete->execute(array("image_id" => $image_id, "user_id" => $user_id));

                $file_path = "src/uploads/" . $image_path;
                if (file_exists($file_path)) {
                    unlink($file_path);
                }

                $connexion->commit();
                return true;
            }

            $connexion->rollBack();
            return false;
        } catch (PDOException $e) {
            $connexion->rollBack();
            throw new Exception("Erreur lors de la suppression de l'image : " . $e->getMessage());
        }
    }

    public static function getUserByUsername($name) {
        include "src/controllers/database.php";

        $requete = $connexion->prepare("SELECT * FROM users WHERE username = :username");
        $requete->execute(array("username" => $name));
        return $requete->fetch(PDO::FETCH_ASSOC);
    }

    public static function getUserByEmail($email) {
        include "src/controllers/database.php";

        $requete = $connexion->prepare("SELECT * FROM users WHERE email = :email");
        $requete->execute(array("email" => $email));
        return $requete->fetch(PDO::FETCH_ASSOC);
    }



}

?>

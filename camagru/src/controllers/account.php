<?php
require_once("src/models/account.php");
class AccountController {
    public function index() {
        session_start();

        if (isset($_SESSION['user_id'])) {
            $user_id = $_SESSION['user_id'];
            $username = $_SESSION['username'];
            $email = $_SESSION['email'];
            
            $images = AccountModel::getMyImages($user_id);

            $mail_notification = AccountModel::getMailNotification($user_id);
            
        } else {
            header("Location: index.php?page=login");
            exit();
        }

        include 'src/views/account.php';
    }

    public function update() {
        session_start();
        
        $existingUsername = AccountModel::getUserByUsername($_POST['username']);
        $existingEmail = AccountModel::getUserByEmail($_POST['email']);
     
        if ($existingUsername && $existingUsername['id'] != $_SESSION['user_id']) {
            echo json_encode(['success' => false, 'message' => 'Le nom d\'utilisateur est déjà utilisé.']);
            exit();
        }

        if ($existingEmail && $existingEmail['id'] != $_SESSION['user_id']) {
            echo json_encode(['success' => false, 'message' => 'L\'adresse e-mail est déjà utilisée.']);
            exit();
        }

        if (isset($_POST['username']) && isset($_POST['email'])) {
            $username = $_POST['username'];
            $email = $_POST['email'];
            $mail_notification = $_POST['email_notifications'];
            $password = $_POST['password'] ?? null;

            if ($password) {
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            } else {
                $hashed_password = null;
            }

            if ($mail_notification == "on") {
                $mail_notification = 1;
            } else {
                $mail_notification = 0;
            }            

            if ($hashed_password) {
                $success = AccountModel::updateUserInfo($username, $email, $mail_notification, $hashed_password);
            } else {
                $success = AccountModel::updateUserInfoWithoutPassword($username, $email, $mail_notification);
            }

            if ($success) {
                $_SESSION['username'] = $username;
                $_SESSION['email'] = $email;
                echo json_encode(['success' => true, 'message' => 'Les informations ont été mises à jour avec succès.']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Erreur lors de la mise à jour des informations']);
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'Données manquantes']);
        }
    }


    public function confirmAccount() {
        if (isset($_GET['email']) && isset($_GET['token'])) {
            $email = htmlspecialchars($_GET['email'], ENT_QUOTES, 'UTF-8');
            $token = htmlspecialchars($_GET['token'], ENT_QUOTES, 'UTF-8');

            try {
                $user = AccountModel::confirmUserAccount($email, $token);

                if ($user) {
                    AccountModel::verifyUser($email);
                    echo "Votre compte a été vérifié avec succès.";
                } else {
                    echo "Lien de confirmation invalide.";
                }
            } catch (Exception $e) {
                echo $e->getMessage();
            }
        } else {
            echo "Paramètres manquants.";
        }
    }

    public function deleteImage() {
        session_start();

        if (isset($_GET['image_id'])) {
            $image_id = $_GET['image_id'];
            $user_id = $_SESSION['user_id'];

            $success = AccountModel::deleteImage($image_id, $user_id);

            if ($success) {
                echo "Image supprimée avec succès.";
            } else {
                echo "Erreur lors de la suppression de l'image.";
            }
        } else {
            echo "Paramètres manquants.";
        }

        header("Location: index.php?page=account");
        exit();
    }   
}
?>
<?php
require_once("src/models/account.php");
class AccountController {
    public function index() {
        session_start();
        // Vérifier si l'utilisateur est connecté
        if (isset($_SESSION['user_id'])) {
            $user_id = $_SESSION['user_id'];
            $username = $_SESSION['username'];
            $email = $_SESSION['email'];
            
            // Utiliser le modèle pour récupérer les images de l'utilisateur
            $images = AccountModel::getMyImages($user_id);

            $mail_notification = AccountModel::getMailNotification($user_id);
            
            // Inclure la vue pour afficher les images de l'utilisateur
            include 'src/views/account.php';
        } else {
            // Rediriger vers la page de connexion si l'utilisateur n'est pas connecté
            header("Location: index.php?page=login");
            exit();
        }

    }

    public function update() {
        session_start();

        if (isset($_POST['username']) && isset($_POST['email'])) {
            // Récupérer les données soumises par le formulair
            $username = $_POST['username'];
            $email = $_POST['email'];
            $mail_notification = $_POST['email_notifications'];
            
            if ($mail_notification == "on") {
                $mail_notification = 1;
            } else {
                $mail_notification = 0;
            }

            // Mettez à jour les informations dans la base de données en utilisant le modèle approprié
            

            $success = AccountModel::updateUserInfo($username, $email, $mail_notification);

            if ($success) {
                // Envoyez une réponse de succès
                echo 'Informations mises à jour avec succès';
            } else {
                // Envoyez une réponse d'erreur
                echo 'Erreur lors de la mise à jour des informations';
            }
        } else {
            // Envoyez une réponse d'erreur si les données du formulaire sont manquantes
            echo 'Données manquantes';
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
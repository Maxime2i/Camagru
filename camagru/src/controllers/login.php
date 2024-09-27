<?php
require_once 'src/models/login.php';

class LoginController {
    public function index() {
        session_start();
        include 'src/views/login.php';

        if (isset($_SESSION['user_id'])) {
            header("Location: index.php?page=homepage");
            exit();
        }
    }

    public function submit() {
        session_start();

        if (isset($_POST['username']) && isset($_POST['password'])){
            $username = htmlspecialchars($_POST['username'], ENT_QUOTES, 'UTF-8');
            $password = htmlspecialchars($_POST['password'], ENT_QUOTES, 'UTF-8');
        
            if ($username != '' && $password != '') {
                $user = LoginModel::getUserByUsername($username);

                if ($user && password_verify($password, $user['pass'])) {
                    if ($user['is_verified'] == 1) {
                        $_SESSION['user_id'] = $user['id'];
                        $_SESSION['username'] = $user['username'];
                        $_SESSION['email'] = $user['email'];
                        echo json_encode(['success' => true, 'message' => 'Connexion réussie']);
                        exit();
                    } else {
                        echo json_encode(['success' => false, 'message' => 'Votre compte n\'est pas encore vérifié. Veuillez vérifier votre e-mail pour activer votre compte.', 'needVerification' => true, 'user_id' => $user['id']]);
                        exit();
                    }
                } else {
                    echo json_encode(['success' => false, 'message' => 'Nom d\'utilisateur ou mot de passe incorrect']);
                    exit();
                }
            }

        }
    }

    public function logout() {
        session_start();
        session_destroy();
        header("Location: index.php?page=login&action=index");
        exit();
    }

    public function resendVerification() {
        session_start();

        if (isset($_GET['user_id'])) {
            $user_id = $_GET['user_id'];

            $user = LoginModel::getUserById($user_id);

            if ($user) {
                $token = LoginModel::updateTokenById($user_id);

                $to = $user['email'];
                $subject = "Vérification de votre compte Camagru";
                $message = "Bonjour " . $user['username'] . ",\n\n";
                $message .= "Veuillez cliquer sur le lien suivant pour vérifier votre compte :\n";
                $message .= "http://localhost:8098/index.php?page=account&action=confirmAccount&email=" . urlencode($user['email']) . "&token=" . $token;

                mail($to, $subject, $message);

                echo json_encode(['success' => true, 'message' => "Un nouvel e-mail de vérification a été envoyé. Veuillez vérifier votre boîte de réception."]);
                exit();
            } else {
                echo json_encode(['success' => false, 'message' => "Utilisateur non trouvé."]);
                exit();
            }
        } else {
            echo json_encode(['success' => false, 'message' => "Identifiant utilisateur manquant."]);
            exit();
        }

        exit();
    }


    public function forgotPassword() {
        if (isset($_POST['email'])){
            $email = htmlspecialchars($_POST['email'], ENT_QUOTES, 'UTF-8');
            $user = LoginModel::getUserByEmail($email);

            if ($user) {
                $token = LoginModel::updateTokenByEmail($email);
                
                $lien_reinitialisation = "http://localhost:8098/index.php?page=resetPassword&id=" . $user['id'] . "&token=" . $token;
                
                $sujet = "Réinitialisation de votre mot de passe";
                $message = "Bonjour,\n\nVous avez demandé à réinitialiser votre mot de passe. Veuillez cliquer sur le lien suivant pour procéder :\n\n" . $lien_reinitialisation . "\n\nSi vous n'avez pas demandé cette réinitialisation, veuillez ignorer ce message.\n\nCordialement,\nL'équipe de votre site";
                
                if (mail($email, $sujet, $message)) {
                    echo json_encode(['success' => true, 'message' => 'Un e-mail de réinitialisation a été envoyé à votre adresse.']);
                    exit();
                } else {
                    echo json_encode(['success' => false, 'message' => 'Erreur lors de l\'envoi de l\'e-mail. Veuillez réessayer.']);
                    exit();
                }
            } else {
                echo json_encode(['success' => false, 'message' => 'Adresse e-mail non trouvée.']);
                exit();
            }
        }
        
        

       

        exit();
    }


}

<?php

class LoginController {
    public function index() {
        include 'src/views/login.php';

        session_start();
        if (isset($_SESSION['user_id'])) {
            header("Location: index.php?page=homepage");
            exit();
        }
    }

    public function submit() {
        include 'src/controllers/database.php';
        session_start();

        if (isset($_POST['submit'])){
            extract($_POST);

            if (strip_tags($username) !== $username || strip_tags($password) !== $password) {
                $_SESSION['login_error'] = 'Les balises HTML ne sont pas autorisées.';
                header("Location: index.php?page=login");
                exit();
            }
        
            // Échappement des Caractères HTML
            $username = htmlspecialchars($username, ENT_QUOTES, 'UTF-8');
            $password = htmlspecialchars($password, ENT_QUOTES, 'UTF-8');
        
        
            if ($username != '' && $password != '') {
                $req = $connexion->prepare("SELECT * FROM users WHERE username = :username AND pass = :pass");
                $req->execute(
                    array(
                        "username" => $username,
                        "pass" => $password,
                    )
                );
                $rep = $req->fetch();
                if ($rep['id'] != false){
                    if ($rep['is_verified'] == 1) {
                        $_SESSION['user_id'] = $rep['id'];
                        $_SESSION['username'] = $rep['username'];
                        $_SESSION['email'] = $rep['email'];
                        header("Location: index.php?page=homepage");
                        exit();
                    } else {
                        $_SESSION['login_error'] = 'Votre compte n\'est pas encore vérifié. Veuillez vérifier votre email. <a href="index.php?page=login&action=resendVerification&user_id=' . $rep['id'] . '">Renvoyer l\'email de vérification</a>';
                        header("Location: index.php?page=login");
                        exit();
                    }
                } else {
                    $_SESSION['login_error'] = 'Nom d\'utilisateur ou mot de passe incorrect';
                    error_log("Erreur de connexion : identifiants incorrects pour l'utilisateur " . $username);
                    header("Location: index.php?page=login");
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
        include 'src/controllers/database.php';

        echo "resendVerification---------";

        if (isset($_GET['user_id'])) {
            $user_id = $_GET['user_id'];
            
            // Récupérer les informations de l'utilisateur
            $req = $connexion->prepare("SELECT email, username FROM users WHERE id = :id");
            $req->execute(['id' => $user_id]);
            $user = $req->fetch();


            if ($user) {
                // Générer un nouveau token de vérification
                $verification_token = bin2hex(random_bytes(16));

                // Mettre à jour le token dans la base de données
                $update = $connexion->prepare("UPDATE users SET token = :token WHERE id = :id");
                $update->execute([
                    'token' => $verification_token,
                    'id' => $user_id
                ]);

                // Envoyer l'e-mail
                echo $user['email'];
                $to = $user['email'];
                $subject = "Vérification de votre compte Camagru";
                $message = "Bonjour " . $user['username'] . ",\n\n";
                $message .= "Veuillez cliquer sur le lien suivant pour vérifier votre compte :\n";
                $message .= "http://localhost:8098/index.php?page=account&action=confirmAccount&email=" . urlencode($user['email']) . "&token=" . $verification_token;

                mail($to, $subject, $message);

                $_SESSION['login_message'] = "Un nouvel e-mail de vérification a été envoyé. Veuillez vérifier votre boîte de réception.";
            } else {
                $_SESSION['login_error'] = "Utilisateur non trouvé.";
            }
        } else {
            $_SESSION['login_error'] = "Identifiant utilisateur manquant.";
        }

        header("Location: index.php?page=login");
        exit();
    }
}

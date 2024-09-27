<?php
require_once 'src/models/register.php';

class RegisterController {
    public function index() {
        include 'src/views/register.php';
        $_SESSION['error'] = "";
    }

    public function submit() {
        session_start();

        if (isset($_POST['submit'])){
            extract($_POST);

            if (strip_tags($username) !== $username || strip_tags($password) !== $password || strip_tags($firstname) !== $firstname || strip_tags($lastname) !== $lastname || strip_tags($email) !== $email) {
                die('Les balises HTML ne sont pas autorisées.');
            }
        
            $username = htmlspecialchars($username, ENT_QUOTES, 'UTF-8');
            $password = htmlspecialchars($password, ENT_QUOTES, 'UTF-8');
            $password = password_hash($password, PASSWORD_DEFAULT);
            $firstname = htmlspecialchars($firstname, ENT_QUOTES, 'UTF-8');
            $lastname = htmlspecialchars($lastname, ENT_QUOTES, 'UTF-8');
            $email = htmlspecialchars($email, ENT_QUOTES, 'UTF-8');

            try {
                $UsernameAlreadyExist = RegisterModel::isUsernameAlreadyTake($username);

                $EmailAlreadyExist = RegisterModel::isEmailAlreadyTake($email);

                if ($UsernameAlreadyExist) {
                    $_SESSION['error'] = "Le nom d'utilisateur est déjà utilisé.";
                    header("Location: index.php?page=register");
                    exit();
                }

                if ($EmailAlreadyExist) {
                    $_SESSION['error'] = "L'adresse email est déjà utilisée.";
                    header("Location: index.php?page=register");
                    exit();
                }

                $token = RegisterModel::createAccount($firstname, $lastname, $username, $email, $password);

                $to = $email;
                $subject = "Confirmez votre inscription";
                $message = "Cliquez sur ce lien pour confirmer votre compte : ";
                $message .= "http://localhost:8098/index.php?page=account&action=confirmAccount&email=$email&token=$token";
                $headers = 'From: maxime.lngls21@gmail.com' . "\r\n" .
    'Reply-To: maxime.lngls21@gmail.com' . "\r\n" .
    'X-Mailer: PHP/' . phpversion();


            if (mail($to, $subject, $message, $headers))
            {
                $_SESSION['success'] = "Compte créé avec succès. Veuillez vérifier votre email pour confirmer votre compte.";
                header("Location: index.php?page=login");
            }

            exit();
        } catch (PDOException $e) {
            $_SESSION['error'] = "Erreur lors de l'ajout de l'utilisateur : " . $e->getMessage();
            header("Location: index.php?page=register");
        }
        }
    }
}

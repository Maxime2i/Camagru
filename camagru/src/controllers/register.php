<?php
require_once 'src/models/register.php';

class RegisterController {
    public function index() {
        include 'src/views/register.php';
    }

    public function submit() {
        session_start();

        if (isset($_POST['username']) && isset($_POST['password']) && isset($_POST['firstname']) && isset($_POST['lastname']) && isset($_POST['email'])){
        
            $username = htmlspecialchars($_POST['username'], ENT_QUOTES, 'UTF-8');
            $password = htmlspecialchars($_POST['password'], ENT_QUOTES, 'UTF-8');
            $password = password_hash($password, PASSWORD_DEFAULT);
            $firstname = htmlspecialchars($_POST['firstname'], ENT_QUOTES, 'UTF-8');
            $lastname = htmlspecialchars($_POST['lastname'], ENT_QUOTES, 'UTF-8');
            $email = htmlspecialchars($_POST['email'], ENT_QUOTES, 'UTF-8');

            try {
                $UsernameAlreadyExist = RegisterModel::isUsernameAlreadyTake($username);

                $EmailAlreadyExist = RegisterModel::isEmailAlreadyTake($email);

                if ($UsernameAlreadyExist) {
                    echo json_encode(['success' => false, 'message' => 'Le nom d\'utilisateur est déjà utilisé.']);
                    exit();
                }

                if ($EmailAlreadyExist) {
                    echo json_encode(['success' => false, 'message' => 'L\'adresse email est déjà utilisée.']);
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
                echo json_encode(['success' => true, 'message' => 'Compte créé avec succès. Veuillez vérifier votre email pour confirmer votre compte.']);
                exit();
            }

            exit();
        } catch (PDOException $e) {
            echo json_encode(['success' => false, 'message' => 'Erreur lors de l\'ajout de l\'utilisateur : ' . $e->getMessage()]);
            exit();
        }
        }
    }
}

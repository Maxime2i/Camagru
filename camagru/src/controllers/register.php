<?php


class RegisterController {
    public function index() {
        // Affiche le formulaire de connexion
        include 'src/views/register.php';
        $_SESSION['error'] = "";
    }

    public function submit() {
        include 'src/controllers/database.php';
        session_start();

        if (isset($_POST['submit'])){
            extract($_POST);

            if (strip_tags($username) !== $username || strip_tags($password) !== $password || strip_tags($firstname) !== $firstname || strip_tags($lastname) !== $lastname || strip_tags($email) !== $email) {
                die('Les balises HTML ne sont pas autorisées.');
            }
        
            // Échappement des Caractères HTML
            $username = htmlspecialchars($username, ENT_QUOTES, 'UTF-8');
            $password = htmlspecialchars($password, ENT_QUOTES, 'UTF-8');
            $password = password_hash($password, PASSWORD_DEFAULT);
            $firstname = htmlspecialchars($firstname, ENT_QUOTES, 'UTF-8');
            $lastname = htmlspecialchars($lastname, ENT_QUOTES, 'UTF-8');
            $email = htmlspecialchars($email, ENT_QUOTES, 'UTF-8');
            $token = bin2hex(random_bytes(50));

            try {
                // Vérification de l'unicité du nom d'utilisateur et de l'email
                // Vérification de l'unicité du nom d'utilisateur
                $checkUsername = $connexion->prepare("SELECT COUNT(*) FROM users WHERE username = :username");
                $checkUsername->execute(["username" => $username]);
                $usernameExists = $checkUsername->fetchColumn();

                // Vérification de l'unicité de l'email
                $checkEmail = $connexion->prepare("SELECT COUNT(*) FROM users WHERE email = :email");
                $checkEmail->execute(["email" => $email]);
                $emailExists = $checkEmail->fetchColumn();

                if ($usernameExists > 0) {
                    $_SESSION['error'] = "Le nom d'utilisateur est déjà utilisé.";
                    header("Location: index.php?page=register");
                    exit();
                }

                if ($emailExists > 0) {
                    $_SESSION['error'] = "L'adresse email est déjà utilisée.";
                    header("Location: index.php?page=register");
                    exit();
                }

                // Si l'utilisateur n'existe pas, procéder à l'insertion
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


                

                $to = $email;
                $subject = "Confirmez votre inscription";
                $message = "Cliquez sur ce lien pour confirmer votre compte : ";
                $message .= "http://localhost:8098/index.php?page=account&action=confirmAccount&email=$email&token=$token";
                $headers = 'From: maxime.lngls21@gmail.com' . "\r\n" .
    'Reply-To: maxime.lngls21@gmail.com' . "\r\n" .
    'X-Mailer: PHP/' . phpversion();


                

if (mail($to, $subject, $message, $headers)) // Envoi du message
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

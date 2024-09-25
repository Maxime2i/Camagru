<?php


class RegisterController {
    public function index() {
        // Affiche le formulaire de connexion
        include 'src/views/register.php';
    }

    public function submit() {
        include 'src/controllers/database.php';
        session_start();
echo "test";
        if (isset($_POST['submit'])){
            extract($_POST);

            if (strip_tags($username) !== $username || strip_tags($password) !== $password || strip_tags($firstname) !== $firstname || strip_tags($lastname) !== $lastname || strip_tags($email) !== $email) {
                die('Les balises HTML ne sont pas autorisées.');
            }
        
            // Échappement des Caractères HTML
            $username = htmlspecialchars($username, ENT_QUOTES, 'UTF-8');
            $password = htmlspecialchars($password, ENT_QUOTES, 'UTF-8');
            $firstname = htmlspecialchars($firstname, ENT_QUOTES, 'UTF-8');
            $lastname = htmlspecialchars($lastname, ENT_QUOTES, 'UTF-8');
            $email = htmlspecialchars($email, ENT_QUOTES, 'UTF-8');
            $token = bin2hex(random_bytes(50));

            try {
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
    echo 'Votre message a bien été envoyé ';
}
else // Non envoyé
{
    echo "Votre message n'a pas pu être envoyé  " . (@error_get_last()['message'] ?? '');
}


                header("Location: index.php?page=login");
                exit();
        } catch (PDOException $e) {
                echo "Erreur lors de l'ajout de l'utilisateur : " . $e->getMessage();
                header("Location: index.php?page=register");
            }
           
        }
    }
}

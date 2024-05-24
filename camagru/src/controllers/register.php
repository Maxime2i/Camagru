<?php


class RegisterController {
    public function index() {
        // Affiche le formulaire de connexion
        include 'src/views/register.php';
    }

    public function submit() {
        include 'src/controllers/database.php';
        session_start();

        if (isset($_POST['submit'])){
            extract($_POST);
            try {
                $requete = $connexion->prepare("INSERT INTO users VALUES (0, :firstname, :lastname, :username, :email, :pass)");
                $requete->execute(
                    array(
                        "firstname" => $firstname,
                        "lastname" => $lastname,
                        "username" => $username,
                        "email" => $email,
                        "pass" => $password,
                    )
                );

                // envoi mail

                ini_set('SMTP', 'smtp.gmail.com');
                ini_set('smtp_port', 587);
                ini_set('sendmail_from', 'maxime.lngls21@gmail.com');

                $token = bin2hex(random_bytes(50));

                $to = $email;
                $subject = "Confirmez votre inscription";
                $message = "Cliquez sur ce lien pour confirmer votre compte : ";
                $message .= "http://votre-site.com/index.php?page=confirm&email=$email&token=$token";
                $headers = 'From: maxime.lngls21@gmail.com' . "\r\n" .
    'Reply-To: maxime.lngls21@gmail.com' . "\r\n" .
    'X-Mailer: PHP/' . phpversion();


                

if (mail($to, $subject, $message, $headers)) // Envoi du message
{
    echo 'Votre message a bien été envoyé ';
}
else // Non envoyé
{
    echo "Votre message n'a pas pu être envoyé  " . $to . "  " . $subject . "  " . $message . "  " . $headers . "  ". $token;
}
                exit();
        } catch (PDOException $e) {
                echo "Erreur lors de l'ajout de l'utilisateur : " . $e->getMessage();
                header("Location: index.php?page=register");
            }
           
        }
    }
}

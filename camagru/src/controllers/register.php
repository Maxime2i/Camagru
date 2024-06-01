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

                $token = bin2hex(random_bytes(50));

                $to = $email;
                $subject = "Confirmez votre inscription";
                $message = "Cliquez sur ce lien pour confirmer votre compte : ";
                $message .= "http://votre-site.com/index.php?page=confirm&email=$email&token=$token";
                $headers = 'From: maxime.lngls21@gmail.com' . "\r\n" .
    'Reply-To: maxime.lngls21@gmail.com' . "\r\n" .
    'X-Mailer: PHP/' . phpversion();

    // $email = htmlspecialchars($_POST['email']);
	// 	$headers = 'From: Admin<admin@camagru.42.fr>' . "\r\n" .
	// 		'Reply-To: <admin@camagru.42.fr>' . "\r\n" .
	// 		'X-Mailer: PHP/' . phpversion();

	// 	$salt = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
	// 	$stryolo = "";
	// 	for ($i=0; $i <= strlen($salt)/2; $i++){
	// 		$stryolo .= $salt[rand() % strlen($salt)];
	// 	}
	// 	$yolohash = htmlspecialchars(hash('md5', $stryolo.$email));
	// 	$link = "http://localhost:8000/client/views/resetpassword.php?reset=".$yolohash;
	// 	$msg = "Please click on the below link to reset your password : \n" . $link;

	// 	mail($email, "Reset Password", $msg, $headers);


                

if (mail($to, $subject, $message, $headers)) // Envoi du message
{
    echo 'Votre message a bien été envoyé ';
}
else // Non envoyé
{
    echo "Votre message n'a pas pu être envoyé  " . (@error_get_last()['message'] ?? '');
}

                exit();
        } catch (PDOException $e) {
                echo "Erreur lors de l'ajout de l'utilisateur : " . $e->getMessage();
                header("Location: index.php?page=register");
            }
           
        }
    }
}

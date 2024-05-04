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
                header("Location: index.php?page=login");
                exit();
        } catch (PDOException $e) {
                echo "Erreur lors de l'ajout de l'utilisateur : " . $e->getMessage();
                header("Location: index.php?page=register");
            }
           
        }
    }
}

<?php


class resetPasswordController {
    public function index() {
        include 'src/views/resetPassword.php';
        $_SESSION['sucess'] = false;



    }

    public function submit() {
        include 'src/controllers/database.php';
        include 'src/views/resetPassword.php';
        
        session_start();
        $sucess = false;

        // Récupération des informations de l'URL
        if (isset($_GET['id']) && isset($_GET['token']) && isset($_POST['password'])) {
            $id = htmlspecialchars($_GET['id'], ENT_QUOTES, 'UTF-8');
            $token = htmlspecialchars($_GET['token'], ENT_QUOTES, 'UTF-8');
            $password = htmlspecialchars($_POST['password'], ENT_QUOTES, 'UTF-8');

            // Vérification de la validité du token
            $requete = $connexion->prepare("SELECT * FROM users WHERE id = :id AND token = :token");
            $requete->execute(array(
                "id" => $id,
                "token" => $token
            ));
            $utilisateur = $requete->fetch();

            if ($utilisateur) {
                // Le token est valide, on peut mettre à jour le mot de passe
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                $update = $connexion->prepare("UPDATE users SET pass = :password WHERE id = :id");
                $update->execute(array(
                    "password" => $hashed_password, // Changé de "pass" à "password"
                    "id" => $id
                ));

           
                $sucess = true;
            } else {
                echo "Token invalide";
            }

            $_SESSION['sucess'] = $sucess;
            header('Location: index.php?page=resetPassword');

            
            // Vous pouvez maintenant utiliser $id et $token pour vérifier la validité de la demande de réinitialisation
            // Par exemple, vérifier dans la base de données si l'ID et le token correspondent
            
            // Si tout est valide, vous pouvez procéder à la réinitialisation du mot de passe
            // Sinon, affichez un message d'erreur
        } else {
            // Rediriger vers une page d'erreur si les paramètres sont manquants
            // header("Location: index.php?");
            exit();
        }
    }

}
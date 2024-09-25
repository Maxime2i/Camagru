<?php

class sendPasswordEmailController {
    public function index() {
        include 'src/views/sendPasswordEmail.php';
        $_SESSION['email_sent'] = false;
    }

    public function sendMail() {
        include 'src/views/sendPasswordEmail.php';

        // Inclure le fichier de connexion à la base de données
        include 'src/controllers/database.php';

        $email_sent = false;
        
        // Récupérer l'e-mail soumis
        $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
        
        // Vérifier si un utilisateur existe avec cet e-mail
        $requete = $connexion->prepare("SELECT * FROM users WHERE email = :email");
        $requete->execute(['email' => $email]);
        $utilisateur = $requete->fetch();
        
        if ($utilisateur) {
            // Générer un token unique
            $token = bin2hex(random_bytes(32));
            
            // Mettre à jour le token dans la base de données
            $update = $connexion->prepare("UPDATE users SET token = :token WHERE email = :email");
            $update->execute([
                'token' => $token,
                'email' => $email
            ]);
            
            // Préparer le lien de réinitialisation
            $lien_reinitialisation = "http://localhost:8098/index.php?page=resetPassword&id=" . $utilisateur['id'] . "&token=" . $token;
            
            // Préparer le contenu du mail
            $sujet = "Réinitialisation de votre mot de passe";
            $message = "Bonjour,\n\nVous avez demandé à réinitialiser votre mot de passe. Veuillez cliquer sur le lien suivant pour procéder :\n\n" . $lien_reinitialisation . "\n\nSi vous n'avez pas demandé cette réinitialisation, veuillez ignorer ce message.\n\nCordialement,\nL'équipe de votre site";
            
            // Envoyer l'e-mail
            if (mail($email, $sujet, $message)) {
                $email_sent = true;
            } else {
                $email_sent = false;
            }
        } else {
            $email_sent = false;
        }

        // Ajouter cette ligne pour passer le résultat à la vue
        $_SESSION['email_sent'] = $email_sent;

        header('Location: index.php?page=sendPasswordEmail');

        exit();
    }
}
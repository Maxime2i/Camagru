<?php

class LoginController {
    public function index() {
        // Affiche le formulaire de connexion
        include 'src/views/login.php';
    }

    public function submit() {
        // Traitement du formulaire de connexion
        // Récupération des données soumises
        $username = $_POST['username'];
        $password = $_POST['password'];

        //DEBUG
        if ($password === '1')
            $test = true;
        else
            $test = false;
        // Validation des données, vérification de l'authentification, etc.

        // Redirection vers la page appropriée
        if ($test) {
            header("Location: index.php?page=homepage");
            exit();
        } else {
            // En cas d'échec de l'authentification, afficher à nouveau le formulaire de connexion avec un message d'erreur
            $error = "Identifiants invalides. Veuillez réessayer.";
            include 'src/views/login.php';
        }
    }
}

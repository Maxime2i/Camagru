<?php
require_once("src/models/account.php");
class AccountController {
    public function index() {
        session_start();
        
        // Vérifier si l'utilisateur est connecté
        if (isset($_SESSION['user_id'])) {
            $user_id = $_SESSION['user_id'];
            $username = $_SESSION['username'];
            $email = $_SESSION['email'];
            
            // Utiliser le modèle pour récupérer les images de l'utilisateur
            $images = AccountModel::getMyImages($user_id);
            
            // Inclure la vue pour afficher les images de l'utilisateur
            include 'src/views/account.php';
        } else {
            // Rediriger vers la page de connexion si l'utilisateur n'est pas connecté
            header("Location: index.php?page=login");
            exit();
        }

    }

    public function update() {
        session_start();
        
        echo"tttttt";
        include 'src/views/account.php';
    }
}


?> 
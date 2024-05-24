<?php
require_once("src/models/homepage.php");

class HomepageController {
    public function index() {
        session_start();
        
        // Vérifier si l'utilisateur est connecté
        if (isset($_SESSION['user_id'])) {
            // Utiliser le modèle pour récupérer les images de l'utilisateur
            $images = HomepageModel::getImages();
            
            // Inclure la vue pour afficher les images de l'utilisateur
            include 'src/views/homepage.php';
        } else {
            // Rediriger vers la page de connexion si l'utilisateur n'est pas connecté
            header("Location: index.php?page=login");
            exit();
        }

    }
    }


?>
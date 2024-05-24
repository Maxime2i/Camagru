 <?php
require_once("src/models/gallery.php");
class GalleryController {
    public function index() {
        // Paramètres de pagination
        $imagesPerPage = 6;
        $currentPage = isset($_GET['page_number']) ? intval($_GET['page_number']) : 1;
        $start = ($currentPage - 1) * $imagesPerPage;
        
        // Utilisation du modèle pour récupérer les images de la galerie pour cette page
        $images = GalleryModel::getImagesByPage($start, $imagesPerPage);
        
        $totalImages = GalleryModel::getTotalImagesCount();
        
        // Calcul du nombre total de pages nécessaires
        $totalPages = ceil($totalImages / $imagesPerPage);

        
        // Récupération des noms d'utilisateur associés à chaque image
        $usernames = [];
        foreach ($images as $image) {
            $usernames[$image['user_id']] = GalleryModel::getUsername($image['user_id']);
        }
        
        // Inclure la vue avec les images paginées
        include 'src/views/gallery.php';
    }


    // Autres méthodes pour d'autres actions de contrôle si nécessaire
}


?> 
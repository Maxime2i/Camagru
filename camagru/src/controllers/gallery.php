 <?php
require_once("src/models/gallery.php");
class GalleryController {
    public function index() {
        // Utilisation du modèle pour récupérer les images de la galerie
        $images = GalleryModel::getAllImages();
        
        // Récupération des noms d'utilisateur associés à chaque image
        $usernames = [];
        foreach ($images as $image) {
            $usernames[$image['user_id']] = GalleryModel::getUsername($image['user_id']);
        }
        
        // Inclure la vue
        include 'src/views/gallery.php';
    }

    // Autres méthodes pour d'autres actions de contrôle si nécessaire
}


?> 
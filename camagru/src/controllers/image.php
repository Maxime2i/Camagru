<?php
require_once 'src/models/image.php';

class ImageController {
    public function show() {
        // Récupérer l'ID de l'image depuis les paramètres de l'URL
        $imageId = $_GET['id'];

        // Récupérer l'URL de l'image depuis l'ID
        $imageUrl = ImageModel::getImageUrlById($imageId);

        // Inclure la vue pour afficher l'image
        include 'src/views/image.php';
    }
}
?>
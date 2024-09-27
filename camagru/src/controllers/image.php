<?php
require_once 'src/models/image.php';

class ImageController {
    public function show() {
        include 'src/views/image.php';

        $imageId = $_GET['id'];

        $imageUrl = ImageModel::getImageUrlById($imageId);
        $imageCompleteUrl = 'src/uploads/' . $imageUrl;

    }

    public function addDescription() {
        include 'src/views/image.php';

        session_start();

        $message = '';
        $success = false;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $description = $_POST['description'];
            $imageUrl = $_POST['imageUrl'];
            $userId = $_SESSION['user_id'];

            $image = ImageModel::getImageByUrl($imageUrl);

            if ($image) {
                $result = ImageModel::updateImageDescription($image['id'], $description);

                if ($result) {
                    $success = true;
                    $message = "La description a été ajoutée avec succès.";
                } else {
                    $message = "Une erreur est survenue lors de l'ajout de la description.";
                }
            } else {
                $message = "L'image n'a pas été trouvée dans la galerie.";
            }
        }

    }


    public function deleteImage() {
        include 'src/views/image.php';

        session_start();

        $delete = false;

        $imageUrl = $_GET['imageUrl'];
        $userId = $_SESSION['user_id'];
        
        $resultat = ImageModel::deleteImage($imageUrl, $userId);

        if ($resultat) {
            $cheminFichier = 'src/uploads/' . basename($imageUrl);
            if (file_exists($cheminFichier)) {
                unlink($cheminFichier);
            }
            
            $delete = true;
        } else {
            exit();
        }
    }
}
?>


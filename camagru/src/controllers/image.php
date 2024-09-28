<?php
require_once 'src/models/image.php';

class ImageController {
    public function show() {
        $imageId = $_GET['id'];

        $imageUrl = ImageModel::getImageUrlById($imageId);
        $imageCompleteUrl = 'src/uploads/' . $imageUrl;

        include 'src/views/image.php';
    }

    public function addDescription() {
        session_start();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $description = $_POST['description'];
            $imageUrl = $_POST['imageUrl'];
            $userId = $_SESSION['user_id'];

            $image = ImageModel::getImageByUrl($imageUrl, $userId);

            if ($image) {
                $result = ImageModel::updateImageDescription($image['id'], $description);

                if ($result) {
                    echo json_encode(['success' => true, 'message' => 'Description ajoutée avec succès', 'imageUrl' => $imageUrl, 'description' => $description]);
                    exit();
                } else {
                    echo json_encode(['success' => false, 'message' => 'Une erreur est survenue lors de l\'ajout de la description']);
                    exit();
                }
            } else {
                echo json_encode(['success' => false, 'message' => 'L\'image n\'a pas été trouvée dans la galerie']);
                exit();
            }
        }

        include 'src/views/image.php';

    }


    public function deleteImage() {
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
        include 'src/views/image.php';

    }
}
?>


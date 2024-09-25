<?php
require_once 'src/models/image.php';

class ImageController {
    public function show() {
        // Récupérer l'ID de l'image depuis les paramètres de l'URL
        $imageId = $_GET['id'];

        // Récupérer l'URL de l'image depuis l'ID
        $imageUrl = ImageModel::getImageUrlById($imageId);
        $imageCompleteUrl = 'src/uploads/' . $imageUrl;

        // Inclure la vue pour afficher l'image
        include 'src/views/image.php';
    }

    public function addDescription() {
        include 'src/controllers/database.php';
        session_start();

        $message = '';
        $success = false;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $description = $_POST['description'];
            $imageUrl = $_POST['imageUrl'];
            $userId = $_SESSION['user_id'];

            // Préparer la requête pour trouver l'image dans la table gallery
            $requete = $connexion->prepare("SELECT id FROM gallery WHERE img = :img AND user_id = :user_id");
            $requete->execute(array(':img' => basename($imageUrl), ':user_id' => $userId));
            $image = $requete->fetch();

            if ($image) {
                // Si l'image est trouvée, mettre à jour la description
                $updateRequete = $connexion->prepare("UPDATE gallery SET description = :description WHERE id = :id");
                $resultat = $updateRequete->execute(array(':description' => $description, ':id' => $image['id']));

                if ($resultat) {
                    $success = true;
                    $message = "La description a été ajoutée avec succès.";
                } else {
                    $message = "Une erreur est survenue lors de l'ajout de la description.";
                }
            } else {
                $message = "L'image n'a pas été trouvée dans la galerie.";
            }
        }

        // Inclure la vue pour afficher le résultat
        include 'src/views/image.php';
    }


    public function deleteImage() {
        include 'src/controllers/database.php';
        session_start();

        $delete = false;

        $imageUrl = $_GET['imageUrl'];
        $userId = $_SESSION['user_id'];
        $imageId = $_GET['imageId'];
        
        // Préparer la requête pour supprimer l'image de la table gallery
        $requete = $connexion->prepare("DELETE FROM gallery WHERE img = :img AND user_id = :user_id");
        $resultat = $requete->execute(array(':img' => basename($imageUrl), ':user_id' => $userId));

        if ($resultat) {
            // Supprimer le fichier physique
            $cheminFichier = 'src/uploads/' . basename($imageUrl);
            if (file_exists($cheminFichier)) {
                unlink($cheminFichier);
            }
            
            $delete = true;
        } else {
        }

        include 'src/views/image.php';
    }
}
?>


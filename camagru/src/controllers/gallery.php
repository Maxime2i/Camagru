 <?php
require_once("src/models/gallery.php");
class GalleryController {
    public function index() {
        session_start();
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

        
        $imageComments = [];
        foreach ($images as $image) {
            $imageComments[$image['id']] = GalleryModel::getImageComments($image['id']);
        }

        
        //var_dump($imageComments);

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['comment']) && isset($_POST['image_id'])) {
            $imageId = $_POST['image_id'];
            // Récupération du user_id depuis la session
            $userId = $_SESSION['user_id'] ?? null;
            $comment = $_POST['comment'];

            // Vérification que l'utilisateur est connecté
            if ($userId === null) {
                // Rediriger vers la page de connexion ou afficher un message d'erreur
                header("Location: /login");
                exit();
            }

            // Appel à la fonction pour ajouter le commentaire
            GalleryModel::addComment($imageId, $userId, $comment);

            // Rediriger vers la page actuelle pour éviter de soumettre à nouveau le formulaire lors du rechargement de la page
            header("Location: {$_SERVER['REQUEST_URI']}");
            exit();
        }
        
        // Inclure la vue avec les images paginées
        include 'src/views/gallery.php';
    }


    public function like() {
        session_start();
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['image_id'])) {
        $imageId = $_POST['image_id'];
        $userId = $_SESSION['user_id'] ?? null;

        if ($userId === null) {
            echo json_encode(['success' => false, 'message' => 'Utilisateur non connecté']);
            exit;
        }

        $image = GalleryModel::getImageById($imageId);
        if (!$image) {
            echo json_encode(['success' => false, 'message' => 'Image non trouvée']);
            exit;
        }

        $likedBy = json_decode($image['liked_by'], true) ?? [];
        $userIndex = array_search($userId, $likedBy);

        if ($userIndex !== false) {
            // L'utilisateur a déjà aimé l'image, on retire son like
            unset($likedBy[$userIndex]);
            $newLikeCount = $image['nb_like'] - 1;
        } else {
            // L'utilisateur n'a pas encore aimé l'image, on ajoute son like
            $likedBy[] = $userId;
            $newLikeCount = $image['nb_like'] + 1;
        }

        $success = GalleryModel::updateImageLikes($imageId, json_encode(array_values($likedBy)), $newLikeCount);

        if ($success) {
            echo json_encode(['success' => true, 'likeCount' => $newLikeCount]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Erreur lors de la mise à jour des likes']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Requête invalide']);
    }
    }


    // Autres méthodes pour d'autres actions de contrôle si nécessaire
}


?>
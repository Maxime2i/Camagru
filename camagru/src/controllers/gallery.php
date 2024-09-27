 <?php
require_once("src/models/gallery.php");

class GalleryController {
    public function index() {
        session_start();
        
        $imagesPerPage = 6;
        $currentPage = isset($_GET['page_number']) ? intval($_GET['page_number']) : 1;
        $start = ($currentPage - 1) * $imagesPerPage;
        
        $images = GalleryModel::getImagesByPage($start, $imagesPerPage);
        
        $totalImages = GalleryModel::getTotalImagesCount();
        
        $totalPages = ceil($totalImages / $imagesPerPage);

        $usernames = [];
        foreach ($images as $image) {
            $usernames[$image['user_id']] = GalleryModel::getUsername($image['user_id']);
        }

        
        $imageComments = [];
        foreach ($images as $image) {
            $imageComments[$image['id']] = GalleryModel::getImageComments($image['id']);
        }
        
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
                unset($likedBy[$userIndex]);
                $newLikeCount = $image['nb_like'] - 1;
            } else {
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


    public function comment() {
        session_start();
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['comment']) && isset($_POST['image_id'])) {
            $imageId = $_POST['image_id'];
            $userId = $_SESSION['user_id'] ?? null;
            $comment = $_POST['comment'];

            if ($userId === null) {
                header("Location: /login");
                exit();
            }

            GalleryModel::addComment($imageId, $userId, $comment);
      
            $username = GalleryModel::getUsername($userId);
            echo json_encode([
                'success' => true,
                'message' => 'Commentaire ajouté',
                'comment' => $_POST['comment'],
                'username' => $username
            ]);
     
              
            exit();
        }
        
    } 
}


?>
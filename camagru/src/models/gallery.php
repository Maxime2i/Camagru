<?php

class GalleryModel {
    public static function getAllImages() {
        include "src/controllers/database.php";
        
        $requete = $connexion->prepare('SELECT * FROM gallery');
        $requete->execute();
        return $requete->fetchAll();
    }

    public static function getImagesByPage($start, $limit) {
        include "src/controllers/database.php";

        $requete = $connexion->prepare("SELECT * FROM gallery ORDER BY id DESC LIMIT :start, :limit");
        $requete->bindParam(':start', $start, PDO::PARAM_INT);
        $requete->bindParam(':limit', $limit, PDO::PARAM_INT);
        $requete->execute();
        $images = $requete->fetchAll(PDO::FETCH_ASSOC);
        return $images;
    }

    public static function getTotalImagesCount() {
        include "src/controllers/database.php";

        $requete = $connexion->query("SELECT COUNT(*) AS total FROM gallery");
        $result = $requete->fetch(PDO::FETCH_ASSOC);
        return $result['total'];
    }

    public static function getUsername($user_id) {
        include "src/controllers/database.php";
        
        $requete_user = $connexion->prepare('SELECT username FROM users WHERE id = :user_id');
        $requete_user->execute(array('user_id' => $user_id));
        $user = $requete_user->fetch();
        return $user['username'];
    }

    public static function addComment($imageId, $userId, $comment) {
        include "src/controllers/database.php";
        // Vérifier si l'image existe
        $requete_check_image = $connexion->prepare("SELECT COUNT(*) AS total FROM gallery WHERE id = ?");
        $requete_check_image->execute([$imageId]);
        $result = $requete_check_image->fetch(PDO::FETCH_ASSOC);
    
        if ($result['total'] == 0) {
            // L'image n'existe pas, retourner une erreur ou effectuer une autre action appropriée
            return false;
        }
    
        // Insérer le commentaire dans la table des commentaires
        $requete_add_comment = $connexion->prepare("INSERT INTO comments (gallery_id, user_id, comment) VALUES (?, ?, ?)");
        $requete_add_comment->execute([$imageId, $userId, $comment]);
    
        return true;
    }

    public static function getImageComments($imageId) {
        include "src/controllers/database.php";

        $requete = $connexion->prepare(
        "SELECT comments.*, users.username 
         FROM comments 
         JOIN users ON comments.user_id = users.id 
         WHERE comments.gallery_id = ?"
        );
        $requete->execute([$imageId]);
        $comments = $requete->fetchAll(PDO::FETCH_ASSOC);
        return $comments;
    }
}

?>

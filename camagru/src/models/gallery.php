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

        // Récupérer l'utilisateur propriétaire de l'image
        $requete_user = $connexion->prepare("SELECT user_id FROM gallery WHERE id = ?");
        $requete_user->execute([$imageId]);
        $image_owner = $requete_user->fetch(PDO::FETCH_ASSOC);

        if ($image_owner) {
            // Récupérer l'email de l'utilisateur propriétaire
            $requete_email = $connexion->prepare("SELECT email FROM users WHERE id = ?");
            $requete_email->execute([$image_owner['user_id']]);
            $user_email = $requete_email->fetch(PDO::FETCH_ASSOC);

            if ($user_email) {
                // Récupérer le nom de l'utilisateur qui a commenté
                $requete_commenter = $connexion->prepare("SELECT username FROM users WHERE id = ?");
                $requete_commenter->execute([$userId]);
                $commenter = $requete_commenter->fetch(PDO::FETCH_ASSOC);

                // Envoyer un email à l'utilisateur
                $to = $user_email['email'];
                $subject = "Nouveau commentaire sur votre photo";
                $message = "Un nouveau commentaire a été ajouté à votre photo sur Camagru par " . $commenter['username'] . ". Le commentaire est : \"" . $comment . "\".";
                $headers = "From: noreply@camagru.com";

                mail($to, $subject, $message, $headers);
            }
        }
    
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


    public static function updateImageLikes($imageId, $likedBy, $newLikeCount) {
        include "src/controllers/database.php";

        $requete = $connexion->prepare("UPDATE gallery SET liked_by = ?, nb_like = ? WHERE id = ?");
        $requete->execute([$likedBy, $newLikeCount, $imageId]);
        return $requete->rowCount() > 0;
    }

    public static function getImageById($imageId) {
        include "src/controllers/database.php";

        $requete = $connexion->prepare("SELECT * FROM gallery WHERE id = ?");
        $requete->execute([$imageId]);
        return $requete->fetch(PDO::FETCH_ASSOC);
    }


}

?>

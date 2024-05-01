<?php

class PostController {
    public function index() {
       
        
        // Se connecter à la base de données
        $servername = "mysql";
        $username = "user";
        $password = "password";
        $dbname = "camagru";
        
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $id = 1;
        // Récupérer les données de l'image depuis la base de données
        $stmt = $conn->prepare("SELECT img_blob, img_type FROM gallery WHERE img_id = :imgId");
        $stmt->bindParam(':imgId', $id); // Supposons que vous passez l'ID de l'image via l'URL ($_GET)
        $stmt->execute();
        $imageData = $stmt->fetch(PDO::FETCH_ASSOC);
        
        // Vérifier si des données d'image ont été récupérées
        if ($imageData) {
            // Convertir les données blob en une URL d'image
            $imgDataEncoded = base64_encode($imageData['img_blob']);
            $imgSrc = 'data:' . $imageData['img_type'] . ';base64,' . $imgDataEncoded;
        ?>
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Image</title>
        </head>
        <body>
            <!-- Afficher l'image -->
            <img src="<?php echo $imgSrc; ?>" alt="Image récupérée depuis la base de données">
        </body>
        </html>
        <?php
        } else {
            // Aucune image trouvée
            echo "Aucune image trouvée avec l'ID spécifié.";
        }
        
        



    }



}

?>
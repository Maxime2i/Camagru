<?php
include 'controllers/database.php';
session_start();

if (isset($_POST['image_id'])) {
    $user_id = $_SESSION['user_id'];
    $liked = ";" . $_SESSION['user_id'] . ";"; 
    $liked2 = $_SESSION['user_id'] . ";"; 
    $image_id = $_POST['image_id'];


    $requete = $connexion->prepare("SELECT liked_by, nb_like  FROM gallery WHERE id = :image_id AND user_id = :user_id");
    $requete->execute(
        array(
            "image_id" => $image_id,
            "user_id" => $user_id
        )
    );

    $resultat = $requete->fetch();

    if ($resultat) {
        $ancienne_valeur_liked_by = $resultat['liked_by'];
        $ancienne_valeur_nb_like = $resultat['nb_like'];

        $new_liked_by_value = 'aaaa';
    
        
        if (strpos($ancienne_valeur_liked_by, $liked) !== false) {

            $new_liked_by_value = str_replace($liked2, '', $ancienne_valeur_liked_by);
            $new_nb_like = $ancienne_valeur_nb_like - 1;

            $requete = $connexion->prepare("UPDATE gallery SET liked_by = :liked_by, nb_like = :nb_like WHERE id = :image_id AND user_id = :user_id");
            $requete->execute(
                array(
                    "liked_by" => $new_liked_by_value,
                    "image_id" => $image_id,
                    "user_id" => $user_id,
                    "nb_like" => $new_nb_like
                )
            );


        } else {

            if ($ancienne_valeur_liked_by != "") {
                $liked = $liked2;
            } else {
                $liked = $liked;
            }
            
            $new_liked_by_value = $ancienne_valeur_liked_by . $liked;
            $new_nb_like = $ancienne_valeur_nb_like + 1;

            $requete = $connexion->prepare("UPDATE gallery SET liked_by = :liked_by, nb_like = :nb_like WHERE id = :image_id AND user_id = :user_id");
            $requete->execute(
                array(
                    "liked_by" => $new_liked_by_value,
                    "image_id" => $image_id,
                    "user_id" => $user_id,
                    "nb_like" => $new_nb_like
                )
            );
        }


        

    } else {
        echo 'No image finded';
    }


    
} else {
    echo 'No image data received';
}

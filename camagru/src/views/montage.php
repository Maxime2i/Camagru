<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="../styles/montage3.css">
</head>
<body>
    <?php include 'header.php'; ?>
    <main>
        <video id="videoElement" class="videoElement" autoplay></video>
    </main>
</body>


<script>
    document.addEventListener("DOMContentLoaded", function() {
    // Récupérer l'élément vidéo
    var video = document.getElementById("videoElement");

    // Vérifier si le navigateur prend en charge l'API MediaDevices
    if (navigator.mediaDevices.getUserMedia) {
        // Demander l'accès à la caméra
        navigator.mediaDevices.getUserMedia({ video: true })
            .then(function(stream) {
                // Afficher le flux de la caméra dans l'élément vidéo
                video.srcObject = stream;
            })
            .catch(function(error) {
                console.log("Erreur getUserMedia: ", error);
            });
    } else {
        console.log("getUserMedia n'est pas pris en charge par ce navigateur.");
    }
});
</script>
</html>
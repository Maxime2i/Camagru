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
        <video id="videoElement" autoplay></video>
        <button id="captureButton">Capture Photo</button>
        <canvas id="canvas" style="display: none;"></canvas>
        <img id="capturedImage" style="display: none;">
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
   
    captureButton.addEventListener("click", function() {
    // Dessiner l'image de la vidéo sur le canvas
    var context = canvas.getContext("2d");
    context.drawImage(video, 0, 0, canvas.width, canvas.height);
    // Récupérer l'image au format base64
    var imageData = canvas.toDataURL("image/png", 0.7);
    console.log(imageData)
    // Envoyer les données de l'image au serveur
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "src/save_image.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4 && xhr.status === 200) {
            console.log("Image envoyée avec succès.");
        }
    };
    xhr.send("imageData=" + encodeURIComponent(imageData) + "&taille=" + canvas.width + "x" + canvas.height + "&type=image/png" + "&userId=1"); // Remplacez "1" par l'ID de l'utilisateur approprié
});
});


</script>
</html>
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
        <form method="POST" name="form1">
            <input name="hidden_data" id='hidden_data' type="hidden"/>
        </form>
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

        var video = document.getElementById('videoElement');
        var canvas = document.getElementById('canvas');
        var context = canvas.getContext('2d');
        context.drawImage(video, 0, 0, 640, 480);
        var imageData = canvas.toDataURL('image/png');

        // Envoi de l'image au serveur
        var xhr = new XMLHttpRequest();
        xhr.open('POST', 'src/save_image.php', true);
        xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        xhr.onload = function() {
            console.log('Image saved:', xhr.responseText);
        };
        xhr.send('image=' + encodeURIComponent(imageData));
    });
});


</script>
</html>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="src/styles/montage.css">
</head>
<body>
    <?php include 'header.php'; ?>
    <main>
        <div class="cameraCol">
            <video id="videoElement" autoplay></video>
            <button id="captureButton" class="captureButton">Capture Photo</button>
            <canvas id="canvas" style="display: none;"></canvas>
            <img id="filterImage" class="filterImage">
            <form method="POST" name="form1">
                <input name="hidden_data" id='hidden_data' type="hidden"/>
            </form>
        </div>
        <div class="filterCol">
            <button id="filterButton" class="filterButton">Filtre 1</button>
            <button id="filterButton2" class="filterButton">Filtre 2</button>
            <button id="filterButton3" class="filterButton">Filtre 3</button>
            <button id="filterButton4" class="filterButton">Filtre 4</button>
            <button id="filterButton5" class="filterButton">Filtre 5</button>
            <button id="filterButton6" class="filterButton">Filtre 6</button>
            <button id="filterButton7" class="filterButton">Filtre 7</button>
            <button id="filterButton8" class="filterButton">Filtre 8</button>
            <button id="filterButton9" class="filterButton">Filtre 9</button>
            <button id="filterButton10" class="filterButton">Sans Filtre</button>
            
        </div>
    </main>
</body>


<script>
    let SelectFilter = 0;
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
        context.drawImage(video, 0, 0, canvas.width, canvas.height);

        var imageData = canvas.toDataURL('image/png');

        if (SelectFilter === 0)
            return;
        var filterImage = new Image();
        filterImage.src = 'filtre' + SelectFilter + '.png';

        filterImage.onload = function() {
        // Dessiner l'image du filtre sur le canevas
            context.drawImage(filterImage, 0, 0, canvas.width, canvas.height);

            // Récupérer les données de l'image avec le filtre
            var filteredImageData = canvas.toDataURL('image/png');

            // Envoi des données au serveur
            var xhr = new XMLHttpRequest();
            xhr.open('POST', 'src/save_image.php', true);
            xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
            xhr.onload = function() {
                console.log('Images saved:', xhr.responseText);
            };
            xhr.send('image=' + encodeURIComponent(imageData) + '&filtered_image=' + encodeURIComponent(filteredImageData));
        };
    });




    document.getElementById('filterButton').addEventListener('click', function() {
            var img = new Image();
            img.onload = function() {
                document.getElementById('filterImage').src = img.src;
                document.getElementById('filterImage').style.display = 'block';
            };
            img.src = 'filtre1.png';
            SelectFilter = 1;
        });

    document.getElementById('filterButton2').addEventListener('click', function() {
        var img = new Image();
        img.onload = function() {
            document.getElementById('filterImage').src = img.src;
            document.getElementById('filterImage').style.display = 'block';
        };
        img.src = 'filtre2.png';
        SelectFilter = 2;
    });

    document.getElementById('filterButton10').addEventListener('click', function() {
        var img = new Image();
        img.onload = function() {
            document.getElementById('filterImage').src = img.src;
            document.getElementById('filterImage').style.display = 'none';
        };
        img.src = 'filtre1.png';
        SelectFilter = 0;
    });



});


</script>
</html>
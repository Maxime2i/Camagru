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
        <div class="montage">
            <div class="cameraCol">
                <div class="videoContainer">
                    <video id="videoElement" autoplay></video>
                    <img id="filterImage" class="filterImage">
                </div>
                <button id="captureButton" class="captureButton">Capture Photo</button>
                <canvas id="canvas" style="display: none;"></canvas>
                <form method="POST" name="form1">
                    <input name="hidden_data" id='hidden_data' type="hidden"/>
                </form>
            </div>
            <div class="filterCol">
                <button id="filterButton1" class="filterButton1">Filtre 1</button>
                <button id="filterButton2" class="filterButton2">Filtre 2</button>
                <button id="filterButton3" class="filterButton3">Filtre 3</button>
                <button id="filterButton4" class="filterButton4">Filtre 4</button>
                <button id="filterButton5" class="filterButton5">Filtre 5</button>
                <button id="filterButton6" class="filterButton6">Filtre 6</button>
                <button id="filterButton7" class="filterButton7">Filtre 7</button>
                <button id="filterButton8" class="filterButton8">Filtre 8</button>
                <button id="filterButton9" class="filterButton9">Filtre 9</button>
                <button id="filterButton10" class="filterButton10">Sans Filtre</button>
                
            </div>
        </div>

        <div class="recentImages">
            <h2>Les 10 dernieres images</h2>
                <div class="images">
                    <?php foreach ($recentImages as $image): ?>
                        <div class="image">
                            <img class="img" src="src/uploads/<?php echo $image['img']; ?>" alt="Image">
                        </div>
                    <?php endforeach; ?>
                </div>
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

    var captureButton = document.getElementById("captureButton");
captureButton.addEventListener("click", function() {
    var canvas = document.getElementById('canvas');
    var context = canvas.getContext('2d');

    // Dessiner l'image de la caméra sur le canvas
    context.drawImage(video, 0, 0, canvas.width, canvas.height);
    var imageData = canvas.toDataURL('image/png');

    var filterImageUrl = '';
    if (SelectFilter !== 0) {
        filterImageUrl = 'assets/filtre' + SelectFilter + '.png';
    }

    // Coordonnées de la position de l'image superposée
    var x = 100; // Exemple : position horizontale
    var y = 50;  // Exemple : position verticale

    // Dimensions de l'image superposée
    var width = document.getElementById('filterImage').style.width;  // Exemple : largeur de l'image superposée
    var height = document.getElementById('filterImage').style.height; // Exemple : hauteur de l'image superposée

    // Envoyer les données des images, les coordonnées de la position et les dimensions au serveur
    sendImage(imageData, filterImageUrl, x, y, width, height);
});

function sendImage(imageData, filterImageUrl, x, y, width, height) {
    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'src/save_image.php', true);
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    xhr.onload = function() {
        console.log('Images saved:', xhr.responseText);
    };
    xhr.send('image=' + encodeURIComponent(imageData) + '&filter_image_url=' + encodeURIComponent(filterImageUrl) + '&x=' + encodeURIComponent(x) + '&y=' + encodeURIComponent(y) + '&width=' + encodeURIComponent(width) + '&height=' + encodeURIComponent(height));
}








document.getElementById('filterButton1').addEventListener('click', function() {
            var img = new Image();
            img.onload = function() {
                document.getElementById('filterImage').src = img.src;
                document.getElementById('filterImage').style.display = 'block';
            };
            img.src = 'src/assets/filtre1.png';
            SelectFilter = 1;
        });

    document.getElementById('filterButton2').addEventListener('click', function() {
        var img = new Image();
        img.onload = function() {
            document.getElementById('filterImage').src = img.src;
            document.getElementById('filterImage').style.display = 'block';
        };
        img.src = 'src/assets/filtre2.png';
        SelectFilter = 2;
    });

    document.getElementById('filterButton3').addEventListener('click', function() {
        var img = new Image();
        img.onload = function() {
            document.getElementById('filterImage').src = img.src;
            document.getElementById('filterImage').style.display = 'block';
            document.getElementById('filterImage').style.width = "50%";
            document.getElementById('filterImage').style.height = "50%";
            document.getElementById('filterImage').style.top = "51%";
            document.getElementById('filterImage').style.left = "5%";

        };
        img.src = 'src/assets/filtre3.png';
        SelectFilter = 3;
    });

    document.getElementById('filterButton4').addEventListener('click', function() {
        var img = new Image();
        img.onload = function() {
            document.getElementById('filterImage').src = img.src;
            document.getElementById('filterImage').style.display = 'block';
        };
        img.src = 'src/assets/filtre4.png';
        SelectFilter = 4;
    });

    document.getElementById('filterButton5').addEventListener('click', function() {
        var img = new Image();
        img.onload = function() {
            document.getElementById('filterImage').src = img.src;
            document.getElementById('filterImage').style.display = 'block';
        };
        img.src = 'src/assets/filtre5.png';
        SelectFilter = 5;
    });

    document.getElementById('filterButton6').addEventListener('click', function() {
        var img = new Image();
        img.onload = function() {
            document.getElementById('filterImage').src = img.src;
            document.getElementById('filterImage').style.display = 'block';
        };
        img.src = 'src/assets/filtre6.png';
        SelectFilter = 6;
    });

    document.getElementById('filterButton7').addEventListener('click', function() {
        var img = new Image();
        img.onload = function() {
            document.getElementById('filterImage').src = img.src;
            document.getElementById('filterImage').style.display = 'block';
        };
        img.src = 'src/assets/filtre7.png';
        SelectFilter = 7;
    });

    document.getElementById('filterButton8').addEventListener('click', function() {
        var img = new Image();
        img.onload = function() {
            document.getElementById('filterImage').src = img.src;
            document.getElementById('filterImage').style.display = 'block';
        };
        img.src = 'src/assets/filtre8.png';
        SelectFilter = 8;
    });

    document.getElementById('filterButton9').addEventListener('click', function() {
        var img = new Image();
        img.onload = function() {
            document.getElementById('filterImage').src = img.src;
            document.getElementById('filterImage').style.display = 'block';
        };
        img.src = 'src/assets/filtre9.png';
        SelectFilter = 9;
    });

    document.getElementById('filterButton10').addEventListener('click', function() {
        // Réinitialiser le filtre sélectionné
        SelectFilter = 0;

        // Cacher l'image du filtre
        var filterImage = document.getElementById('filterImage');
        filterImage.src = '';  // Réinitialiser la source
        filterImage.style.display = 'none';  // Cacher l'élément
    });


});


</script>
</html>
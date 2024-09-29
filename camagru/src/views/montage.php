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
                    <img id="uploadedImage" class="uploadedImage" style="display:none;">
                    <img id="filterImage" class="filterImage">
                </div>
                <button id="captureButton" class="captureButton">Capture Photo</button>
                <label class="uploadImage">
                    <input type="file" id="uploadImage" class="uploadImage" accept="image/*">
                </label>
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
        // Récupérer les éléments vidéo et image téléchargée
        var video = document.getElementById("videoElement");
        var uploadedImage = document.getElementById("uploadedImage");
        var canvas = document.getElementById('canvas');
        var context = canvas.getContext('2d');

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
        captureButton.disabled = true; // Désactiver le bouton au chargement

        captureButton.addEventListener("click", function() {
            // Définir les dimensions du canvas en fonction des dimensions de la vidéo

            // canvas.width = video.videoWidth;
            // canvas.height = video.videoHeight;

            // Dessiner l'image de la caméra ou l'image téléchargée redimensionnée sur le canvas
            if (uploadedImage.style.display === 'none') {
                context.drawImage(video, 0, 0, canvas.width, canvas.height);
            } else {
                context.drawImage(uploadedImage, 0, 0, canvas.width, canvas.height);
            }

            var imageData = canvas.toDataURL('image/png');

            var filterImageUrl = '';
            if (SelectFilter !== 0) {
                filterImageUrl = 'assets/filtre' + SelectFilter + '.png';
            }

            // Envoyer les données des images redimensionnées au serveur
            sendImage(imageData, filterImageUrl);
        });

        function sendImage(imageData, filterImageUrl) {
            var xhr = new XMLHttpRequest();
            xhr.open('POST', 'src/save_image.php', true);
            xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
            xhr.onload = function() {
                if (xhr.status === 200) {
                    try {
                        // Essayer de parser la réponse comme JSON
                        var response = JSON.parse(xhr.responseText);
                        console.log('Images sauvegardées:', response.image_id);
                        // Rediriger vers la page de l'image sauvegardée
                        window.location.href = 'index.php?page=image&action=show&id=' + response.image_id;
                    } catch (e) {
                        // Si le parsing échoue, afficher la réponse brute
                        console.error('Erreur lors du parsing de la réponse:', xhr.responseText);
                    }
                } else {
                    console.error('Erreur lors de la sauvegarde de l\'image:', xhr.statusText);
                }
            };
            xhr.send('image=' + encodeURIComponent(imageData) + '&filter_image_url=' + encodeURIComponent(filterImageUrl));
        }

        var uploadImage = document.getElementById('uploadImage');
        uploadImage.addEventListener('change', function(event) {
            var file = event.target.files[0];
            if (file) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    var img = new Image();
                    img.onload = function() {
                        // Obtenir les dimensions de la vidéo
                        var videoWidth = video.videoWidth || video.clientWidth;
                        var videoHeight = video.videoHeight || video.clientHeight;

                        // Calculer le ratio pour redimensionner l'image
                        var ratio = Math.min(videoWidth / img.width, videoHeight / img.height);
                        var newWidth = img.width * ratio;
                        var newHeight = img.height * ratio;

                        // Créer un canvas temporaire pour redimensionner l'image
                        var tempCanvas = document.createElement('canvas');
                        tempCanvas.width = videoWidth;
                        tempCanvas.height = videoHeight;
                        var ctx = tempCanvas.getContext('2d');

                        // Dessiner l'image redimensionnée au centre du canvas
                        ctx.drawImage(img, 
                            (videoWidth - newWidth) / 2, 
                            (videoHeight - newHeight) / 2, 
                            newWidth, 
                            newHeight
                        );

                        // Afficher l'image redimensionnée
                        uploadedImage.src = tempCanvas.toDataURL('image/png');
                        uploadedImage.style.display = 'block';
                        video.style.display = 'none';
                    };
                    img.src = e.target.result;
                };
                reader.readAsDataURL(file);
            }
        });

        // Fonction pour mettre à jour l'état du bouton de capture
        function updateCaptureButtonState() {
            captureButton.disabled = SelectFilter === 0;
        }

        // Modifier les gestionnaires d'événements des boutons de filtre
        for (let i = 1; i <= 10; i++) {
            document.getElementById('filterButton' + i).addEventListener('click', function() {
                var img = new Image();
                img.onload = function() {
                    document.getElementById('filterImage').src = img.src;
                    document.getElementById('filterImage').style.display = 'block';
                };
                if (i < 10) {
                    img.src = 'src/assets/filtre' + i + '.png';
                    SelectFilter = i;
                } else {
                    // Réinitialiser pour le bouton "Sans Filtre"
                    document.getElementById('filterImage').src = '';
                    document.getElementById('filterImage').style.display = 'none';
                    SelectFilter = 0;
                }
                updateCaptureButtonState();
            });
        }

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
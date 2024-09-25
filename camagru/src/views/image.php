<!-- language:camagru/src/views/show_image.php -->
<?php
$imageUrl = isset($imageUrl) ? $imageUrl : '';
$description = isset($description) ? $description : '';
$imageCompleteUrl = isset($imageCompleteUrl) ? $imageCompleteUrl : '';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Image Enregistrée</title>
    <link rel="stylesheet" href="src/styles/image.css">
</head>
<body>
    <?php include 'header.php'; ?>
    <div class="container">
        <?php if ($imageUrl): ?>
            <div class="image-container">
                <?php if (!$success): ?>
                    <?php if (!$delete): ?>
                        <img src="<?php echo htmlspecialchars($imageCompleteUrl); ?>" alt="Image enregistrée" class="saved-image">
                        <form action="index.php?page=image&action=addDescription" method="post" class="description-form"> <!-- Formulaire pour soumettre la description -->
                            <textarea name="description" placeholder="Écrivez une description..."><?php echo htmlspecialchars($description); ?></textarea>
                            <input type="hidden" name="imageUrl" value="<?php echo htmlspecialchars($imageUrl); ?>">
                            <button type="submit">Publier la description</button>
                        </form>
                <?php else: ?>
                        <p class="success-message">
                            <p>Votre image a été supprimée avec succès.</p>
                            <button onclick="window.location.href='index.php?page=montage'">Faire un nouveau montage</button>
                        </p>
                    <?php endif; ?>
                <?php else: ?>
                    <?php if (!$delete): ?>
                        <img src="<?php echo 'src/uploads/' . htmlspecialchars($imageUrl); ?>" alt="Image enregistrée" class="saved-image">
                        <p class="success-message">
                            <?php echo $description; ?>
                            <p>Votre description a été ajoutée avec succès.</p>
                            <button onclick="window.location.href='index.php?page=image&action=deleteImage&imageUrl=<?php echo htmlspecialchars($imageUrl); ?>'">Supprimer l'image</button>
                            <button onclick="window.location.href='index.php?page=gallery'">Voir dans la galerie</button>
                            
                            <!-- Ajout des boutons de partage sur les réseaux sociaux avec logos -->
                            <div class="social-share">
                                <button onclick="shareOnFacebook()" class="share-button facebook">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M9 8h-3v4h3v12h5v-12h3.642l.358-4h-4v-1.667c0-.955.192-1.333 1.115-1.333h2.885v-5h-3.808c-3.596 0-5.192 1.583-5.192 4.615v3.385z"/></svg>
                                    Partager sur Facebook
                                </button>
                                <button onclick="shareOnTwitter()" class="share-button twitter">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z"/></svg>
                                    Partager sur Twitter
                                </button>
                            </div>
                        </p>
                    <?php else: ?>
                        <p class="success-message">
                            <p>Votre image a été supprimée avec succès.</p>
                            <button onclick="window.location.href='index.php?page=montage'">Faire un nouveau montage</button>
                        </p>
                    <?php endif; ?>
                <?php endif; ?>
            </div>
        <?php else: ?>
            <p class="no-image">Aucune image à afficher.</p>
        <?php endif; ?>
    </div>
</body>
<style>
.social-share {
    margin-top: 20px;
}

.share-button {
    display: inline-flex;
    align-items: center;
    padding: 10px 15px;
    margin-right: 10px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    font-size: 14px;
    color: white;
    transition: background-color 0.3s;
}

.share-button svg {
    margin-right: 10px;
    fill: white;
}

.facebook {
    background-color: #3b5998;
}

.facebook:hover {
    background-color: #2d4373;
}

.twitter {
    background-color: #1da1f2;
}

.twitter:hover {
    background-color: #0c85d0;
}
</style>
<script>
function shareOnFacebook() {
    var url = encodeURIComponent(window.location.href);
    window.open('https://www.facebook.com/sharer/sharer.php?u=' + url, '_blank');
}

function shareOnTwitter() {
    var url = encodeURIComponent(window.location.href);
    var text = encodeURIComponent('Regardez cette image que j\'ai créée sur Camagru !');
    window.open('https://twitter.com/intent/tweet?url=' + url + '&text=' + text, '_blank');
}

</script>
</html>
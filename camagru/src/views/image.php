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
</html>
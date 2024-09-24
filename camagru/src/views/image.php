<!-- language:camagru/src/views/show_image.php -->
<?php
$imageUrl = isset($imageUrl) ? $imageUrl : '';
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
            <h1 class="title">Votre image enregistrée</h1>
            <div class="image-container">
                <img src="<?php echo htmlspecialchars($imageUrl); ?>" alt="Image enregistrée" class="saved-image">
            </div>
        <?php else: ?>
            <p class="no-image">Aucune image à afficher.</p>
        <?php endif; ?>
    </div>
</body>
</html>
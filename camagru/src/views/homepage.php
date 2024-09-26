<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Camagru - Accueil</title>
    <link rel="stylesheet" href="src/styles/homepage.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
</head>
<body>
    <?php include 'header.php'; ?>
    <main>
        <section class="hero">
            <h1>Bienvenue sur Camagru</h1>
            <p>Créez des montages photos uniques et partagez-les avec le monde !</p>
            <a href="index.php?page=montage" class="cta-button">Créer un montage</a>
        </section>


        <section class="recent-photos">
            <h2>Photos récentes</h2>
            <div class="images-grid">
                <?php foreach ($images as $image): ?>
                    <div class="image-card">
                        <img src="src/uploads/<?php echo $image['img']; ?>" alt="Photo récente">
                        <div class="image-info">
                            <span class="author"><?php echo $image['author']; ?></span>
                            <span class="likes"><?php echo $image['nb_like']; ?> ❤️</span>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            <a href="index.php?page=gallery" class="view-more">Voir plus</a>
        </section>
    </main>

    <footer>
        <p>&copy; 2023 Camagru. Tous droits réservés.</p>
    </footer>
</body>
</html>
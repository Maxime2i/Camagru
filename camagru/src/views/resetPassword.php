<?php
session_start();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Réinitialisation du mot de passe</title>
    <link rel="stylesheet" href="src/styles/resetPassword.css">
    <!-- Ajout de la police Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;700&display=swap" rel="stylesheet">
</head>
<body>
    <div class="container">
        <div class="form-wrapper">
            <h2>Réinitialisation du mot de passe</h2>
            <?php if (isset($_SESSION['sucess']) && $_SESSION['sucess']): ?>
                <p class="success-message">Votre mot de passe a été réinitialisé avec succès.</p>
                <a href="index.php?page=login" class="button">Retour à la connexion</a>
            <?php else: ?>
                <form action="index.php?page=resetPassword&action=submit&id=<?php echo $_GET['id']; ?>&token=<?php echo $_GET['token']; ?>" method="post">
                    <div class="input-group">
                        <label for="password">Nouveau mot de passe</label>
                        <input type="password" id="password" name="password" required>
                    </div>
                    <button type="submit" class="button">Valider</button>
                </form>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>


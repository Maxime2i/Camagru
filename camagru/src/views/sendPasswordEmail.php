<?php
session_start();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Réinitialisation du mot de passe</title>
    <link rel="stylesheet" href="src/styles/sendPasswordEmail.css">

</head>
<body>
    <div class="container">
        <div class="form-wrapper">
            <?php if (isset($_SESSION['email_sent']) && $_SESSION['email_sent']): ?>
                <div class="success-message">
                    Un e-mail de réinitialisation de mot de passe a été envoyé à votre adresse e-mail.
                </div>
                <div class="button-container">
                    <a href="index.php?controller=login&action=index" class="return-button">Retourner à la connexion</a>
                </div>
            <?php else: ?>
                <form action="index.php?page=sendPasswordEmail&action=sendMail" method="post">
                    <h2>Réinitialisation du mot de passe</h2>
                    <p>Entrez votre adresse e-mail pour recevoir un lien de réinitialisation du mot de passe.</p>
                    <input type="email" name="email" placeholder="Votre adresse e-mail" required>
                    <input type="submit" value="Envoyer le lien de réinitialisation">
                </form>
            <?php endif; ?>
            
        </div>
    </div>
</body>
</html>

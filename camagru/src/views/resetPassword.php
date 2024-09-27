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
</head>
<body>
    <div class="container">
        <div class="form-wrapper">
            <h2>Réinitialisation du mot de passe</h2>
                <form method="post" onsubmit="return validatePassword()">
                    <div class="input-group">
                        <label for="password">Nouveau mot de passe</label>
                        <input type="password" id="password" name="password" required>
                    </div>
                    <button type="submit" class="button">Valider</button>
                </form>
        </div>
    </div>
</body>
<script>

    function validatePassword() {
        var password = document.getElementById('password').value;
        var errorElement = document.getElementById('error-message');
        var valid = true;
        if (password.length < 8) {
            errorElement.textContent = "Le mot de passe doit contenir au moins 8 caractères.";
            valid = false;
        } else if (!/[A-Z]/.test(password)) {
            errorElement.textContent = "Le mot de passe doit contenir au moins une lettre majuscule.";
            valid = false;
        } else if (!/\d/.test(password)) {
            errorElement.textContent = "Le mot de passe doit contenir au moins un chiffre.";
            valid = false;
        }
        if (valid) {
            var xhr = new XMLHttpRequest();
            xhr.open('POST', '?page=resetPassword&action=submit', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onload = function() {
                if (xhr.status === 200) {
                    console.log(xhr);
                    var response = JSON.parse(xhr.responseText);
                    if (response.success) {
                        document.querySelector('.form-wrapper').innerHTML = '<p class="success-message">' + response.message + '</p><a href="index.php?page=login" class="button">Retour à la connexion</a>';
                    } else {
                        errorElement.textContent = response.message;
                    }
                } else {
                    errorElement.textContent = "Une erreur s'est produite. Veuillez réessayer.";
                }
            };
            xhr.send('password=' + encodeURIComponent(password));
        } else {
            return false;
        }
        return true;
    }
</script>
</html>


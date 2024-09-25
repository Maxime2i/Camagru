<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
    <link rel="stylesheet" href="src/styles/login.css">
    <script>
        function GoToRegister() {
            window.location.href = "index.php?page=register";
        }
    </script>
</head>
<body>
    <main>
        <img src="src/assets/logoWithoutBackground.png" alt="Logo" class="logo">
        <form action="?page=login&action=submit" method="post" onsubmit="return validateForm()">
            <h2>Connexion</h2>
            <input type="text" name="username" id="username" placeholder="Nom d'utilisateur" required>
            <input type="password" name="password" id="password" placeholder="Mot de passe" required>
            <span id="username-error" class="error"></span>
            <span id="password-error" class="error"></span>
            <a href="index.php?page=sendPasswordEmail" class="forgot-password">Mot de passe oublié ?</a>
            <?php if (isset($_SESSION['login_error'])): ?>
                <div class="error-message">
                    <?php 
                    echo $_SESSION['login_error'];
                    unset($_SESSION['login_error']);
                    ?>
                </div>
            <?php endif; ?>
            <?php if (isset($_SESSION['login_message'])): ?>
                <div class="success-message">
                    <?php 
                    echo $_SESSION['login_message'];
                    unset($_SESSION['login_message']);
                    ?>
                </div>
            <?php endif; ?>
            <input type="submit" value="Se connecter" name="submit">
            <button onClick="GoToRegister()" class="registerBtn">S'inscrire</button>
        </form>
    </main>
    <script src="src/scripts/login-validation.js"></script>
</body>
</html>
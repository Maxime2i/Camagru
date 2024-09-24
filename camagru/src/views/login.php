<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="src/styles/login.css">
    <script>
        // Définition de la fonction à exécuter au clic
        function GoToRegister() {
            window.location.href = "index.php?page=register";
        }
    </script>
</head>
<body>
    <main>
        <form action="?page=login&action=submit" method="post" onsubmit="return validateForm()">
            <h2>Login</h2>
            <input type="text" name="username" id="username" placeholder="Username" required>
            <span id="username-error" style="color: red;"></span>
            <input type="password" name="password" id="password" placeholder="Password" required>
            <span id="password-error" style="color: red;"></span>
            <?php if (isset($_SESSION['login_error'])): ?>
                <div class="error-message" style="color: red;">
                    <?php 
                    echo $_SESSION['login_error'];
                    unset($_SESSION['login_error']); // Effacer le message après l'avoir affiché
                    ?>
                </div>
            <?php endif; ?>
            <?php if (isset($_SESSION['login_message'])): ?>
                <div class="success-message" style="color: green;">
                    <?php 
                    echo $_SESSION['login_message'];
                    unset($_SESSION['login_message']); // Effacer le message après l'avoir affiché
                    ?>
                </div>
            <?php endif; ?>
            <input type="submit" value="Login" name="submit">
            <button type="button" onClick="GoToRegister()" class="registerBtn">register</button>
        </form>
    </main>
</body>

<script>
    function validateForm() {
        var password = document.getElementById("password").value;
        var passwordError = document.getElementById("password-error");
        var username = document.getElementById("username").value;
        var usernameError = document.getElementById("username-error");

         // Vérification de l'absence de balises HTML
         var htmlRegex = /<\/?[a-z][\s\S]*>/i;
        if (htmlRegex.test(username) || htmlRegex.test(password)) {
            if (htmlRegex.test(username)) {
                usernameError.textContent = "Les balises HTML ne sont pas autorisées.";
            }
            if (htmlRegex.test(password)) {
                passwordError.textContent = "Les balises HTML ne sont pas autorisées.";
            }
            return false;
        }

        if (username.length < 3) {
            usernameError.textContent = "Le nom d'utilisateur doit contenir au moins 3 caractères.";
            return false;
        } else {
            usernameError.textContent = "";
        }

        if (password.length < 8) {
            passwordError.textContent = "Le mot de passe doit contenir au moins 8 caractères.";
            return false;
        } else {
            passwordError.textContent = "";
        }

        var uppercaseRegex = /[A-Z]/;
        if (!uppercaseRegex.test(password)) {
            passwordError.textContent = "Le mot de passe doit contenir au moins une lettre majuscule.";
            return false;
        } else {
            passwordError.textContent = "";
        }

        // Vérifie si le mot de passe contient au moins un chiffre
        var digitRegex = /\d/;
        if (!digitRegex.test(password)) {
            passwordError.textContent = "Le mot de passe doit contenir au moins un chiffre.";
            return false;
        } else {
            passwordError.textContent = "";
        }

       


        return true;
    }
</script>
</html>
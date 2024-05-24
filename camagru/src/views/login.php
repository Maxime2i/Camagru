<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="src/styles/login2.css">
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
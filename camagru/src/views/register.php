<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="src/styles/register.css">
</head>
<body>
    <main>

        <form action="?page=register&action=submit" method="post" onsubmit="return validateForm()">
            <h2>Register</h2>
            <input type="text" name="firstname" placeholder="Firstname" required>
            <input type="text" name="lastname" placeholder="Lastname" required>
            <input type="text" name="username" id="username" placeholder="Username" required>
            <span id="username-error" style="color: red;"></span>
            <input type="email" name="email" placeholder="E-mail" required>
            <input type="password" name="password" id="password" placeholder="Password" required>
            <span id="password-error" style="color: red;"></span>
            <input type="submit" value="Register" name="submit">
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
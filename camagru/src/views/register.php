<?php
session_start();
?>
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
        <img src="src/assets/logoWithoutBackground.png" alt="Logo" class="logo">
        <form action="?page=register&action=submit" method="post" onsubmit="return validateForm()">
            <h2>Inscription</h2>
            <input type="text" name="firstname" id="firstname" placeholder="Prénom" required>
            <input type="text" name="lastname" id="lastname" placeholder="Nom" required>
            <input type="text" name="username" id="username" placeholder="Nom d'utilisateur" required>
            <input type="email" name="email" id="email" placeholder="E-mail" required>
            <input type="password" name="password" id="password" placeholder="Mot de passe" required>
            <p class="error-message" id="error-message"> <?php if (isset($_SESSION['error']) && $_SESSION['error']): ?><?php echo $_SESSION['error']; ?> <?php endif; ?></p>
            <input type="submit" value="S'inscrire" name="submit">
        </form>
        <button onclick="window.location.href='index.php?page=login'" class="login-btn">Se connecter</button>
    </main>
    <script src="src/scripts/register-validation.js"></script>
</body>
</html>

<script>
    function validateForm() {
        var fields = ['firstname', 'lastname', 'username', 'email', 'password'];
        var valid = true;
        var errorElement = document.getElementById('error-message');
        console.log(errorElement);

        fields.forEach(function(field) {
            var value = document.getElementById(field).value;

            var htmlRegex = /<\/?[a-z][\s\S]*>/i;

            if (htmlRegex.test(value)) {
                errorElement.textContent = 'Les balises HTML ne sont pas autorisées.';
                valid = false;
            } else {
                errorElement.textContent = '';
                
                if (field === 'username' && value.length < 3) {
                    errorElement.textContent = "Le nom d'utilisateur doit contenir au moins 3 caractères.";
                    valid = false;
                } else if (field === 'password') {
                    if (value.length < 8) {
                        errorElement.textContent = "Le mot de passe doit contenir au moins 8 caractères.";
                        valid = false;
                    } else if (!/[A-Z]/.test(value)) {
                        errorElement.textContent = "Le mot de passe doit contenir au moins une lettre majuscule.";
                        valid = false;
                    } else if (!/\d/.test(value)) {
                        errorElement.textContent = "Le mot de passe doit contenir au moins un chiffre.";
                        valid = false;
                    }
                }
            }
        });
        return valid;
    }
</script>
</html>
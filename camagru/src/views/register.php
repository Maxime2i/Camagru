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
        var fields = ['firstname', 'lastname', 'username', 'email', 'password'];
        var valid = true;

        fields.forEach(function(field) {
            var value = document.getElementById(field).value;
            var errorElement = document.getElementById(field + '-error');
            var htmlRegex = /<\/?[a-z][\s\S]*>/i;

            if (htmlRegex.test(value)) {
                errorElement.textContent = 'Les balises HTML ne sont pas autorisées.';
                valid = false;
            } else {
                errorElement.textContent = '';
            }

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
                } else {
                    errorElement.textContent = '';
                }
            }
        });

        return valid;
    }
</script>
</html>
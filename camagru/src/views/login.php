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
    <form action="?page=login&action=submit" method="post">
        <h2>Login</h2>
        <input type="text" name="username" placeholder="Username" required>
        <input type="password" name="password" placeholder="Password" required>
        <input type="submit" value="Login" name="submit">
        <button type="button" onClick="GoToRegister()">register</button>
    </form>
    
</body>
</html>
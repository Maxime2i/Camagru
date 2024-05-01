<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="src/styles/login.css">
</head>
<body>
    <form action="?page=register&action=submit" method="post">
        <h2>Register</h2>
        <input type="text" name="firstname" placeholder="Firstname" required>
        <input type="text" name="lastname" placeholder="Lastname" required>
        <input type="text" name="username" placeholder="Username" required>
        <input type="email" name="email" placeholder="E-mail" required>
        <input type="password" name="password" placeholder="Password" required>
        <input type="submit" value="Register" name="submit">
    </form>
</body>
</html>
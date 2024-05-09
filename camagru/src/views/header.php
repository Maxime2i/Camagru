<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Header avec logo, barre blanche et photo de profil</title>
    <link rel="stylesheet" href="src/styles/header2.css">
</head>
<body>

<header>
    <div class="logo">
        <img src="src/logo.jpg" alt="Logo">
    </div>
    <div class="spacer">
        <nav class="nav">
            <ul>
                <li><a href="index.php?page=montage">Montage</a></li>
                <li><a href="index.php?page=gallery">Galerie</a></li>
                <li><a href="index.php?page=account">Account</a></li>
            </ul>
        </nav>
    </div>
    <div class="profile">
        <!-- <img src="profil.jpg" alt="Photo de profil"> -->
        <button id="logout">Logout</button>
    </div>
</header>

</body>
<script>
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('logout').addEventListener('click', function(event) {
                event.preventDefault();
                window.location.href = "index.php?page=login&action=logout";
                
            });
        });
    </script>
</html>

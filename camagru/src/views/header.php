<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Header avec logo, barre blanche et photo de profil</title>
    <link rel="stylesheet" href="src/styles/header.css">
</head>
<body>

<header>
    <div class="logo">
        <a href="index.php?page=homepage" class="logo-link">
            <img src="src/assets/logoWithoutBackground.png" alt="Logo">
        </a>
    </div>
    <nav class="nav">
        <button class="menu-toggle" aria-label="Toggle menu">
            <span></span>
            <span></span>
            <span></span>
        </button>
        <ul class="nav-list">
            <li><a href="index.php?page=montage">Montage</a></li>
            <li><a href="index.php?page=gallery">Galerie</a></li>
            <li><a href="index.php?page=account">Compte</a></li>
        </ul>
    </nav>
    <div class="profile">
        <!-- <img src="profil.jpg" alt="Photo de profil"> -->
        <button id="logout">Logout</button>
    </div>
</header>

</body>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const menuToggle = document.querySelector('.menu-toggle');
        const navList = document.querySelector('.nav-list');

        menuToggle.addEventListener('click', function() {
            navList.classList.toggle('show');
        });

        document.getElementById('logout').addEventListener('click', function(event) {
            event.preventDefault();
            window.location.href = "index.php?page=login&action=logout";
        });
    });
</script>
</html>

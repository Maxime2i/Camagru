<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="src/styles/account.css">
</head>
<body>
    <?php include 'header.php'; ?>
    <main>
        <div class="divInfo">
            <h2>My infos</h2>
            <form class="formInfo" id="updateForm">
                <input type="text" name="username" placeholder="Username" value="<?php echo $username; ?>" required>
                <input type="email" name="email" placeholder="Email" value="<?php echo $email; ?>" required>
                <input type="password" name="password" placeholder="Password" id="password" required>
                <input type="submit" value="Update" name="submit">
            </form>
        </div>
        <div class="divImage">
            <h2>My images</h2>
                <div class="images">
                    <?php foreach ($images as $image): ?>
                        <div class="image">
                            <img src="src/uploads/<?php echo $image['img']; ?>" alt="Image">
                        </div>
                    <?php endforeach; ?>
                </div>
        </div>
            

        
    </main>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('updateForm').addEventListener('submit', function(event) {
                event.preventDefault(); // Empêcher le comportement de soumission par défaut
                
                // Récupérer les données du formulaire
                var formData = new FormData(this);
                
                // Envoyer une requête AJAX
                var xhr = new XMLHttpRequest();
                xhr.open('POST', 'index.php?page=account&action=update', true);
                xhr.onreadystatechange = function() {
                    if (xhr.readyState === XMLHttpRequest.DONE) {
                        if (xhr.status === 200) {
                            // Mettre à jour la page en fonction de la réponse du serveur
                            // Par exemple, afficher un message de réussite ou d'erreur
                            console.log(xhr.responseText);
                            document.getElementById('password').value = '';
                        } else {
                            console.error('Une erreur s\'est produite');
                        }
                    }
                };
                xhr.send(formData);
            });
        });
    </script>
</body>
</html>
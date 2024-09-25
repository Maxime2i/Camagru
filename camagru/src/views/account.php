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
            <h2>Mes informations</h2>
            <form class="formInfo" id="updateForm">
                <input type="text" name="username" placeholder="Nom d'utilisateur" value="<?php echo $username; ?>" required>
                <input type="email" name="email" placeholder="E-mail" value="<?php echo $email; ?>" required>
                <input type="password" name="password" placeholder="Mot de passe" id="password" required>
                <!-- Nouvelle case à cocher pour les notifications par e-mail -->
                <label>
                    <input type="checkbox" name="email_notifications" <?php echo $mail_notification ? 'checked' : ''; ?>>
                    Recevoir des e-mails pour les commentaires sur mes photos
                </label>
                <button type="submit" name="submit">Mettre à jour</button>
            </form>
        </div>
        <div class="divImage">
            <h2>Mes images</h2>
            <div class="images">
                <?php foreach ($images as $image): ?>
                    <div class="image">
                        <img src="src/uploads/<?php echo $image['img']; ?>" alt="Image">
                        <a href="index.php?page=account&action=deleteImage&image_id=<?php echo $image['id']; ?>" class="deleteButton" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette image ?');">Supprimer</a>
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
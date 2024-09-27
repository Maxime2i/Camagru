<?php
    session_start();
?>
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
                <!-- Nouvelle case à cocher pour les notifications par e-mail -->
                <label>
                    <input type="checkbox" name="email_notifications" <?php echo $mail_notification ? 'checked' : ''; ?>>
                    <span>Recevoir des e-mails pour les commentaires sur mes photos</span>
                </label>
                    
                    <p class="error" id="errorMessage"></p>
                    <p class="success" id="successMessage"></p>

                <button type="submit" name="submit">Mettre à jour</button>
            </form>
        </div>
        <div class="divImage">
            <h2>Mes images</h2>
            <div class="images">
                <?php foreach ($images as $image): ?>
                    <div class="image">
                        <img src="src/uploads/<?php echo $image['img']; ?>" alt="Image">
                        <button class="deleteButton" data-image-id="<?php echo $image['id']; ?>">Supprimer</button>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
            

        
    </main>
    <script>

        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('updateForm').addEventListener('submit', function(event) {
                event.preventDefault(); // Empêcher le comportement de soumission par défaut

                var errorMessage = document.getElementById('errorMessage');
                var successMessage = document.getElementById('successMessage');
                
                // Récupérer les données du formulaire
                var formData = new FormData(this);
                
                // Envoyer une requête AJAX
                var xhr = new XMLHttpRequest();
                xhr.open('POST', 'index.php?page=account&action=update', true);
                xhr.onreadystatechange = function() {
                    if (xhr.readyState === XMLHttpRequest.DONE) {
                        if (xhr.status === 200) {
                            var response = JSON.parse(xhr.responseText);
                            if (response.success) {
                                errorMessage.style.display = 'none';
                                successMessage.textContent = response.message;
                                successMessage.style.display = 'block';
                                // Mettre à jour la page en fonction de la réponse du serveur
                                // Par exemple, afficher un message de réussite ou d'erreur
                                console.log(response.message);
                            } else {
                                successMessage.style.display = 'none';
                                errorMessage.textContent = response.message;
                                errorMessage.style.display = 'block';
                            }
                            // Mettre à jour la page en fonction de la réponse du serveur
                            // Par exemple, afficher un message de réussite ou d'erreur
                            console.log(xhr.responseText);
                        } else {
                            console.error('Une erreur s\'est produite');
                        }
                    }
                };
                xhr.send(formData);
            });




            document.querySelectorAll('.deleteButton').forEach(button => {
                button.addEventListener('click', function() {
                // Remplacer le bouton supprimer par des boutons oui et non avec confirmation
                const imageId = this.getAttribute('data-image-id');
                const buttonContainer = this.parentElement;

                // Cacher le bouton supprimer
                this.style.display = 'none';

                // Créer le texte de confirmation
                const confirmText = document.createElement('p');
                confirmText.textContent = 'Êtes-vous sûr de vouloir supprimer cette image ?';
                confirmText.classList.add('confirmText');

                // Créer le bouton "Oui"
                const ouiButton = document.createElement('button');
                ouiButton.textContent = 'Oui';
                ouiButton.classList.add('confirmButton');
                ouiButton.addEventListener('click', function() {
                    // Rediriger vers la page de suppression
                    window.location.href = `index.php?page=account&action=deleteImage&image_id=${imageId}`;
                });

                // Créer le bouton "Non"
                const nonButton = document.createElement('button');
                nonButton.textContent = 'Non';
                nonButton.classList.add('cancelButton');
                nonButton.addEventListener('click', function() {
                    // Restaurer le bouton supprimer original
                    buttonContainer.innerHTML = '';
                    buttonContainer.appendChild(button);
                    button.style.display = 'block';
                });

                // Ajouter le texte et les nouveaux boutons
                buttonContainer.appendChild(confirmText);
                buttonContainer.appendChild(ouiButton);
                buttonContainer.appendChild(nonButton);
                });
            });
        });


    </script>
</body>
</html>
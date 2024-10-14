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
                <input type="password" name="password" placeholder="Mot de passe (laisser vide si vous ne voulez pas le changer)">
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
    <?php include 'footer.php'; ?>

    <script>

        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('updateForm').addEventListener('submit', function(event) {
                event.preventDefault(); 

                var errorMessage = document.getElementById('errorMessage');
                var successMessage = document.getElementById('successMessage');
                var passwordInput = document.querySelector('input[name="password"]');
                
                var formData = new FormData(this);
                
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
                                successMessage.style.opacity = '1';
                                
                                // Effacer le champ du mot de passe
                                passwordInput.value = '';

                                setTimeout(function() {
                                    fadeOut(successMessage);
                                }, 3000);
                            } else {
                                successMessage.style.display = 'none';
                                errorMessage.textContent = response.message;
                                errorMessage.style.display = 'block';
                                errorMessage.style.opacity = '1';

                                setTimeout(function() {
                                    fadeOut(errorMessage);
                                }, 3000);
                            }
                        } else {
                            console.error('Une erreur s\'est produite');
                        }
                    }
                };
                xhr.send(formData);
            });

            function fadeOut(element) {
                var opacity = 1;
                var timer = setInterval(function() {
                    if (opacity <= 0.1) {
                        clearInterval(timer);
                        element.style.display = 'none';
                    }
                    element.style.opacity = opacity;
                    opacity -= opacity * 0.1;
                }, 50);
            }

            document.querySelectorAll('.deleteButton').forEach(button => {
                button.addEventListener('click', function() {
                    const imageId = this.getAttribute('data-image-id');
                    const buttonContainer = this.parentElement;

                    this.style.display = 'none';

                    const confirmContainer = document.createElement('div');
                    confirmContainer.classList.add('confirmContainer');

                    const confirmText = document.createElement('span');
                    confirmText.textContent = 'Supprimer ? ';
                    confirmText.classList.add('confirmText');

                    const ouiButton = document.createElement('button');
                    ouiButton.innerHTML = 'Oui';
                    ouiButton.classList.add('confirmButton');
                    ouiButton.addEventListener('click', function() {
                        window.location.href = `index.php?page=account&action=deleteImage&image_id=${imageId}`;
                    });

                    const nonButton = document.createElement('button');
                    nonButton.innerHTML = 'Non';
                    nonButton.classList.add('cancelButton');
                    nonButton.addEventListener('click', function() {
                        buttonContainer.removeChild(confirmContainer);
                        button.style.display = 'block';
                    });

                    confirmContainer.appendChild(confirmText);
                    confirmContainer.appendChild(ouiButton);
                    confirmContainer.appendChild(nonButton);

                    buttonContainer.appendChild(confirmContainer);
                });
            });
        });


    </script>
</body>
</html>

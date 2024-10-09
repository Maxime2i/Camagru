<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
    <link rel="stylesheet" href="src/styles/login.css">
    <script>
        function GoToRegister() {
            window.location.href = "index.php?page=register";
        }
    </script>
</head>
<body>
    <main>
        <img src="src/assets/logoWithoutBackground.png" alt="Logo" class="logo">
        <form action="?page=login&action=submit" method="post" onsubmit="return validateForm()">
            <h2>Connexion</h2>
            <input type="text" name="username" id="username" placeholder="Nom d'utilisateur" required>
            <input type="password" name="password" id="password" placeholder="Mot de passe" required>
            <span id="error-message" class="error"></span>
            <a href="#" onclick="forgotPassword()" class="forgot-password">Mot de passe oublié ?</a>
            <input type="submit" value="Se connecter" name="submit">
            <button onClick="GoToRegister()" class="registerBtn">S'inscrire</button>
        </form>
    </main>
</body>
<script>
    function validateForm() {
        var password = document.getElementById("password").value;
        var username = document.getElementById("username").value;
        var errorElement = document.getElementById("error-message");

        event.preventDefault();

        var xhr = new XMLHttpRequest();

        xhr.open('POST', '?page=login&action=submit', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

        xhr.onload = function() {
            if (xhr.status === 200) {
                var response = JSON.parse(xhr.responseText);
                if (response.success) {
                    window.location.href = 'index.php?page=homepage';
                } else {
                    if (response.needVerification) {
                        errorElement.innerHTML = response.message + ' <a href="#" onclick="resendVerificationLink(' + response.user_id + ')" style="color: blue;">Renvoyer l\'e-mail de vérification</a>';
                    } else {
                        errorElement.textContent = response.message;
                    }
                }
            } else {
                console.error('Erreur de requête. Statut:', xhr.status);
            }
        };

        var formData = 'username=' + encodeURIComponent(username) + '&password=' + encodeURIComponent(password);
        xhr.send(formData);

        return false;
    }



    function resendVerificationLink(userId) {
        var xhr = new XMLHttpRequest();
        xhr.open('GET', '?page=login&action=resendVerification&user_id=' + encodeURIComponent(userId), true);
        xhr.onload = function() {
            if (xhr.status === 200) {
                var response = JSON.parse(xhr.responseText);
                if (response.success) {
                    document.getElementById('error-message').innerHTML = '<span style="color: green;">' + response.message + '</span>';
                } else {
                    document.getElementById('error-message').textContent = "Une erreur s'est produite lors de l'envoi de l'e-mail de vérification. Veuillez réessayer.";
                }
            } else {
                console.error('Erreur de requête. Statut:', xhr.status);
            }
        };
        xhr.send();
    }






    function forgotPassword() {
        var errorElement = document.getElementById("error-message");
        if (document.getElementById('forgot-password-form')) {
            var forgotPasswordLink = document.querySelector('a[onclick="forgotPassword()"]');
            if (forgotPasswordLink) {
                forgotPasswordLink.innerHTML = 'Mot de passe oublié ?';
                forgotPasswordLink.style.fontSize = ''; 
                forgotPasswordLink.style.textDecoration = ''; 
                forgotPasswordLink.title = ''; 
            }
            document.getElementById('forgot-password-form').remove(); 
            document.getElementById('username').disabled = false; 
            document.getElementById('password').disabled = false; 
            return;
        }


        var forgotPasswordLink = document.querySelector('a[onclick="forgotPassword()"]');
        if (forgotPasswordLink) {
            forgotPasswordLink.innerHTML = '&#10005;'; 
            forgotPasswordLink.style.fontSize = '20px'; 
            forgotPasswordLink.style.textDecoration = 'none'; 
            forgotPasswordLink.title = 'Mot de passe oublié'; 
        }

        var formContainer = document.createElement('div');
        formContainer.id = 'forgot-password-form';
        formContainer.style.marginTop = '10px';
        formContainer.style.boxSizing = 'border-box';

        var emailInput = document.createElement('input');
        emailInput.type = 'email';
        emailInput.id = 'forgot-password-email';
        emailInput.placeholder = 'Entrez votre adresse e-mail';
        emailInput.required = true;
        emailInput.style.width = '100%';
        emailInput.style.padding = '10px';
        emailInput.style.marginBottom = '10px';
        emailInput.style.borderRadius = '5px';
        emailInput.style.border = '1px solid #ccc';
        emailInput.style.boxSizing = 'border-box';

        var submitButton = document.createElement('button');
        submitButton.textContent = 'Envoyer le mail de réinitialisation';
        submitButton.style.width = '100%';
        submitButton.style.padding = '10px';
        submitButton.style.backgroundColor = '#4CAF50';
        submitButton.style.color = 'white';
        submitButton.style.border = 'none';
        submitButton.style.borderRadius = '5px';
        submitButton.style.cursor = 'pointer';
        submitButton.style.transition = 'background-color 0.3s';
        submitButton.style.boxSizing = 'border-box';
        submitButton.onmouseover = function() { this.style.backgroundColor = '#45a049'; };
        submitButton.onmouseout = function() { this.style.backgroundColor = '#4CAF50'; };

        document.getElementById('username').disabled = true;
        document.getElementById('password').disabled = true;

        submitButton.onclick = function() {
            var email = emailInput.value;
            var xhr = new XMLHttpRequest();
            xhr.open('POST', '?page=login&action=forgotPassword', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onload = function() {
                if (xhr.status === 200) {
                    var response = JSON.parse(xhr.responseText);
                    if (response.success) {
                        var forgotPasswordLink = document.querySelector('a[onclick="forgotPassword()"]');
                    if (forgotPasswordLink) {
                            forgotPasswordLink.innerHTML = 'Mot de passe oublié ?';
                            forgotPasswordLink.style.fontSize = ''; 
                            forgotPasswordLink.style.textDecoration = '';
                            forgotPasswordLink.title = '';
                        }
                        document.getElementById('forgot-password-form').remove(); 
                        document.getElementById('username').disabled = false; 
                        document.getElementById('password').disabled = false;
                        errorElement.innerHTML = '<span style="color: green;">' + response.message + '</span>';

                        return;
                    } else {
                        errorElement.textContent = response.message;
                    }
                } else {
                    errorElement.textContent = 'Une erreur s\'est produite. Veuillez réessayer.';
                }
            };
            xhr.send('email=' + encodeURIComponent(email));
        };

        formContainer.appendChild(emailInput);
        formContainer.appendChild(submitButton);

        document.querySelector('.forgot-password').insertAdjacentElement('beforebegin', formContainer);
    }
</script>
</html>
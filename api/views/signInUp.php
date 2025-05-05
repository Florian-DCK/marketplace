<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/global.css">  
    <title>Hello World - inscription</title>
</head>
    <?php

    require_once __DIR__ . '/../../vendor/autoload.php';

    $mustache = new Mustache_Engine([
        'loader' => new Mustache_Loader_FilesystemLoader(__DIR__ . '/../templates'),
        'partials_loader' => new Mustache_Loader_FilesystemLoader(__DIR__ . '/../templates/partials')
    ]);

    $data = [
        "inscription" => isset($_GET['login']) ?? $_GET['login'],
    ];

    echo $mustache->render('signInUp', $data);

    ?>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const inscriptionForm = document.querySelector('form[name="inscription"]');
        if (inscriptionForm) {
            // Fonction pour afficher une erreur
            function showError(inputId, message) {
                const input = document.getElementById(inputId);
                // Supprimer l'erreur précédente si elle existe
                let errorElement = input.parentNode.querySelector('.error-message');
                if (errorElement) {
                    errorElement.remove();
                }
                // Créer et afficher le nouveau message d'erreur
                errorElement = document.createElement('span');
                errorElement.className = 'error-message';
                errorElement.style.color = 'red';
                errorElement.style.position = 'absolute';
                errorElement.style.left = '0px';
                errorElement.style.top = '-20px';
                errorElement.style.display = 'block';
                errorElement.textContent = message;
                input.parentNode.style.position = 'relative';
                input.parentNode.appendChild(errorElement);
                
                // Ajouter une bordure rouge à l'input
                input.style.border = '1px solid red';
                
                return false;
            }
            
            // Fonction pour nettoyer les erreurs
            function clearErrors() {
                document.querySelectorAll('.error-message').forEach(el => el.remove());
                document.querySelectorAll('input').forEach(el => el.style.border = 'none')
            }
            
            inscriptionForm.addEventListener('submit', function(e) {
                e.preventDefault();
                
                // Nettoyer les erreurs précédentes
                clearErrors();
                
                // Récupération des champs
                const password = document.getElementById('password').value;
                const confirmPassword = document.getElementById('confirmPassword').value;
                const email = document.getElementById('email').value;
                const lastName = document.getElementById('lastName').value;
                const firstName = document.getElementById('firstName').value;
                const phoneNumber = document.getElementById('phoneNumber').value;
                
                let isValid = true;
                
                // Vérification du mot de passe
                if (password !== confirmPassword) {
                    isValid = showError('confirmPassword', "Passwords don't match") && isValid;
                }

                if (password.length < 8 ||!/[A-Z]/.test(password)||!/[0-9]/.test(password)||!/[!@#$%^&*(),.?":{}|<>]/.test(password)) {
                    isValid = showError('password', "Must be at least 8 characters, have a special character and a digit") && isValid;
                }
                
                // Vérification de l'email avec regex simple
                const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                if (!emailRegex.test(email)) {
                    isValid = showError('email', "Please enter a valid mail address") && isValid;
                }

                if (email.length > 50) {
                    isValid = showError('email', "Your mail exceed 50 characters") && isValid;
                }

                if (lastName.length > 50) {
                    isValid = showError('lastName', "Your last name exceed 50 characters") && isValid;
                }

                if (firstName.length > 50) {
                    isValid = showError('firstName', "Your first name exceed 50 characters") && isValid;
                }

                if (phoneNumber.length > 50) {
                    isValid = showError('phoneNumber', "Your phone number exceed 50 characters") && isValid;
                }
                
                // Si toutes les vérifications sont passées, soumettre le formulaire
                if (isValid) {
                    this.submit();
                }
            });
        }
    });
</script>
</html>
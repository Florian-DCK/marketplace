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

    $errorCode = isset($_GET['error']) ? $_GET['error'] : null;
    $errorMessage = [];

    if($errorCode == "EmailAlreadyUsed"){
        array_push($errorMessage, "Email already used");
        $errorCode = [];
    } elseif($errorCode == "InvalidCredentials"){
        array_push($errorMessage, "Invalid credentials");
        $errorCode = [];
    } elseif ($errorCode !== null) {
        $errorCode = str_split($errorCode, 1);
    } else {
        $errorCode = [];
    }
    
    foreach ($errorCode as $key => $value) {
        switch ($key) {
            case 0:
                if ($value == 1) {
                    array_push($errorMessage, "Your email exceed 50 characters");
                }
                break;
            case 1:
                if ($value == 1) {
                    array_push($errorMessage, "Your last name exceed 50 characters");
                }
                break;
            case 2:
                if ($value == 1) {
                    array_push($errorMessage, "Your first name exceed 50 characters");
                }
                break;
            case 3:
                if ($value == 1) {
                    array_push($errorMessage, "Your phone number exceed 50 characters");
                }
                break;
            case 4:
                if ($value == 1) {
                    array_push($errorMessage, "Email already used");
                }
                break;
        }
    }
    
    $fieldErrors = [
        'firstNameError' => null,
        'lastNameError' => null,
        'birthDateError' => null,
        'avatarError' => null,
        'phoneNumberError' => null,
        'emailError' => null,
        'passwordError' => null,
        'confirmPasswordError' => null,
    ];

    foreach ($errorCode as $key => $value) {
        switch ($key) {
            case 0:
                if ($value == 1) $fieldErrors['emailError'] = "Your email exceeds 50 characters";
                break;
            case 1:
                if ($value == 1) $fieldErrors['lastNameError'] = "Your last name exceeds 50 characters";
                break;
            case 2:
                if ($value == 1) $fieldErrors['firstNameError'] = "Your first name exceeds 50 characters";
                break;
            case 3:
                if ($value == 1) $fieldErrors['emailError'] = "Email already used";
                break;
            case 4:
                if ($value == 1) $fieldErrors['passwordError'] = "Password must be at least 8 characters, include a digit and a special character";
                break;
            case 5:
                if ($value == 1) $fieldErrors['confirmPasswordError'] = "Passwords do not match";
                break;
        }
    }

    $data = array_merge([
        "inscription" => $_GET['login'] ?? null,
        "error" => $errorMessage,
    ], $fieldErrors);

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
                errorElement.style.bottom = '-20px';
                errorElement.style.fontSize = '12px';
                errorElement.style.whiteSpace = 'nowrap';
                errorElement.style.maxWidth = '100%';
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
                document.querySelectorAll('input').forEach(el => el.style.border = '1px solid transparent');
            }
            
            inscriptionForm.addEventListener('submit', function(e) {
                e.preventDefault();
                
                // Nettoyer les erreurs précédentes
                clearErrors();
                
                // Récupération des champs
                const password = document.getElementById('passwordRegister').value;
                const confirmPassword = document.getElementById('confirmPasswordRegister').value;
                const email = document.getElementById('email').value;
                const lastName = document.getElementById('lastName').value;
                const firstName = document.getElementById('firstName').value;
                const phoneNumber = document.getElementById('phoneNumber').value;
                
                let isValid = true;
                
                // Vérification du mot de passe
                if (password !== confirmPassword) {
                    console.log('Password value:', password, 'Confirm Password Value:', confirmPassword); // Affiche directement la valeur
                    isValid = showError('confirmPasswordRegister', "Passwords don't match") && isValid;
                }

                if (password.length < 8 ||!/[A-Z]/.test(password)||!/[0-9]/.test(password)||!/[!@#$%^&*(),.?":{}|<>]/.test(password)) {
                    isValid = showError('passwordRegister', "Must be at least 8 characters, have a special character and a digit") && isValid;
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
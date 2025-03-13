<?php
    include __DIR__ . "/../models/users/signInUpModel.php";
    $email = isset($_POST['email']) ? $_POST['email'] : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';

    $result = connection($email, $password);
    if($result == true) {header("Location: /");}; // Page d'accueil après connexion
    echo "Erreur lors de la connexion"

    
?>
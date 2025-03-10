<?php
    include __DIR__ . "/../models/connection_et_inscription/connection.php";
    $email = isset($_POST['email']) ? $_POST['email'] : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';

    $result = connection($email, $password);
    if($result == true) {header("Location: ../../api/index.php");}; // Page d'accueil après connexion

    
?>
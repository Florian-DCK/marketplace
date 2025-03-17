<?php
    include __DIR__ . "/../models/users/signInUpModel.php";
    $email = isset($_POST['email']) ? $_POST['email'] : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';

    $result = connection($email, $password);
    if($result == true){
    // Démarrer la session
    session_start();
        
    // Stocker des informations sur l'utilisateur dans la session
    $_SESSION['id'] = $user_id;
    $_SESSION['name'] = $last_name;
    $_SESSION['surname'] = $first_name ;
    $_SESSION['avatar'] = $avatar ;
    header("Location: ../../api/index.php");}; // Page d'accueil après connexion
    echo "Erreur lors de la connexion"  
?>
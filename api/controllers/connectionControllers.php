<?php
    include __DIR__ . "/../models/users/signInUpModel.php";
    include __DIR__ . '/../models/users/getInfosModel.php';

    // Récupérer les valeurs du formulaire
    $email = isset($_POST['email']) ? $_POST['email'] : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';

    // Appeler la fonction pour récupérer les informations de l'utilisateur
    $user = getUserInfo($email);

    // Vérifier si l'utilisateur existe et si le mot de passe est correct
    if ($user && password_verify($password, $user['pass'])) {
        // Démarrer la session
        session_start();
        
        // Stocker les informations de l'utilisateur dans la session
        $_SESSION['id'] = $user['id'];
        $_SESSION['name'] = $user['name'];
        $_SESSION['surname'] = $user['surname'];
        $_SESSION['avatar'] = $user['avatar'];
        
        // Rediriger vers la page d'accueil ou autre
        header("Location: ../../api/index.php"); 
        echo "Connexion réussie";
    } else {
        echo "Erreur lors de la connexion";
    }
?>

<?php
ob_start(); // Ajouter un buffer de sortie au début du fichier
include __DIR__ . "/../models/users/signInUpModel.php";
include __DIR__ . "/../models/images.php";
include __DIR__ . "/showErrorControllers.php";

// Récupération des données envoyées via POST
$nom = $_POST['lastName'];
$prenom = $_POST['firstName'];
$mdp = $_POST['passwordRegister'];
$mdpConfirm = $_POST['confirmPasswordRegister'];
$email = $_POST['email']; 
$telephone = $_POST['phoneNumber'];
$avatar = $_FILES['image'] ? $_FILES['image'] : null; 
$birthDate = $_POST['birthDate'];
$creation_date = date('Y-m-d H:i:s');  // Date actuelle pour la création
$last_modified = $creation_date;  // Date actuelle pour la modification
$isActive = 1;  
$operator_level = 1;  

// Vérification que les mots de passe sont identiques
if ($mdp !== $mdpConfirm) {
    // Si les mots de passe ne correspondent pas, rediriger avec un message d'erreur
    header("Location: /login?login=true&error=PasswordMismatch");
    exit;
}

$avatar_id = image_upload($avatar)['id'];

$result;
try {
    // Tente d'exécuter l'inscription
    $result = inscription($nom, $prenom, $mdp, $email, $telephone, $avatar_id, $birthDate);
} catch (Exception $e) {
    // Si une exception est lancée, appelle showError() avec le message d'erreur de l'exception
    showError($e->getMessage());
    exit;
}

ob_end_clean(); // Nettoyer le buffer avant la redirection

// Redirections en fonction du résultat de l'inscription
if ($result == "success") {
    header("Location: /login");
    exit;
} elseif ($result != "success"){
    header("Location: /login?error=$result&login=true");
    exit;
}

else {
    showError($result);
}
?>


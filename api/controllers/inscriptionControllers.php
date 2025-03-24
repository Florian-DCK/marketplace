<?php
ob_start(); // Ajouter un buffer de sortie au début du fichier
include __DIR__ . "/../models/users/signInUpModel.php";
include __DIR__ . "/../models/images.php";
include __DIR__ . "/showErrorControllers.php";
// Récupération des données envoyées via POST
$nom = $_POST['lastName'];
$prenom = $_POST['firstName'];
$mdp = $_POST['password'];
$mdpConfirm = $_POST['confirmPassword'];
$email = $_POST['email']; 
$telephone = $_POST['phoneNumber'];
$avatar = $_FILES['image'] ? $_FILES['image'] : null; 
$birthDate = $_POST['birthDate'];
$creation_date = date('Y-m-d H:i:s');  // Date actuelle pour la création
$last_modified = $creation_date;  // Date actuelle pour la modification
$isActive = 1;  
$operator_level = 1;  
// Hachage du mot de passe pour plus de sécurité
$mdp_hash = password_hash($mdp, PASSWORD_DEFAULT);
// Upload de l'avatar
$avatar_id = image_upload($avatar)['id'];
$result;
try {
    // Tente d'exécuter l'inscription
    $result = inscription($nom, $prenom, $mdp_hash, $email, $telephone, $avatar_id, $birthDate);
} catch (Exception $e) {
    // Si une exception est lancée, appelle showError() avec le message d'erreur de l'exception
    showError($e->getMessage());
    exit;
}


ob_end_clean(); // Nettoyer le buffer avant la redirection
if($result == "success") {
    header("Location: /login");
    exit;
}  elseif ($result == 'EmailAlreadyUsed') { 
    header("Location: /login?error=EmailAlreadyUsed");
    exit;
} elseif ($result == 'PasswordTooLong'){
    header ("Location: /login?error=PasswordTooLong");  
} elseif ($result == 'NameTooLong'){
    header ("Location: /login?error=NameTooLong");  
} elseif ($result == 'FirstNameTooLong'){
    header ("Location: /login?error=FirstNameTooLong");  
} elseif ($result == 'PhoneNumberTooLong'){
    header ("Location: /login?error=PhoneNumberTooLong");  
}
else{
    showError($result);
}
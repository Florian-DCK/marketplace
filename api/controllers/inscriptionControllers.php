<?php
   include __DIR__ . "/../models/users/signInUpModel.php";
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
   

   $result = inscription($nom=null,$prenom=null,$mdp=null,$email=null,$telephone=null,$avatar=null,$birthDate=null);
    if($result == true) {header("Location: /login");} // Page d'accueil après connexion
    else{ 
        return header("Location: /login?error=EmailAlreadyUsed");
    }
?>
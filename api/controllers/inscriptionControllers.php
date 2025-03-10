<?php
   include __DIR__ . "/../models/connection_et_inscription/connexionInscription.php";
   // Récupération des données envoyées via POST
   $nom = $_POST['lastName'];
   $prenom = $_POST['firstName'];
   $mdp = $_POST['password'];
   $mdpConfirm = $_POST['confirmPassword'];
   $email = $_POST['email']; 
   $telephone = $_POST['phoneNumber'];
   $avatar = $_POST['avatar']; 
   $birthDate = $_POST['birthDate'];
   $creation_date = date('Y-m-d H:i:s');  // Date actuelle pour la création
   $last_modified = $creation_date;  // Date actuelle pour la modification
   $isActive = 1;  
   $operator_level = 1;  
   // Hachage du mot de passe pour plus de sécurité
   $mdp_hash = password_hash($mdp, PASSWORD_DEFAULT);

   $result = inscription($nom=null,$prenom=null,$mdp=null,$email=null,$telephone=null,$avatar=null,$birthDate=null);
    if($result == true) {header("Location: ../../api/views/login/signIn-signUp.php");}; // Page d'accueil après connexion
?>
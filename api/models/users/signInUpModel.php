<?php

// Inclure le fichier de connexion à la base de données
require_once __DIR__ . '/db/connect.php';

function connection($email=null, $password=null){
    global $db; // Utilisation de la variable globale $db
    $error_msg = '';

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Récupération des données du formulaire
    
        // Vérification que les champs sont non vides
        if ($email != "" && $password != "") {
            // Préparation de la requête pour vérifier l'email et le mot de passe
            $stmt = $db->prepare("SELECT * FROM User WHERE email = :email");
            $stmt->bindParam(':email', $email);
            $stmt->execute();
    
            // Récupération de l'utilisateur correspondant à l'email
            $user = $stmt->fetch();
    
            // Si l'utilisateur existe
            if ($user) {
                // Vérification du mot de passe
                if (password_verify($password, $user['pass'])) {
                    // Redirection vers la page après connexion réussie
                    return true;
                } 
            } else {
                // erreur l'utilisateur n'existe pas 
                echo "Error user not found";
                return false;
            }
        } 
    }
}

function inscription($nom=null, $prenom=null, $mdp=null, $email=null, $telephone=null, $avatar=null, $birthDate=null){
    global $db; // Utilisation de la variable globale $db
    
    if (isset($_POST['ok'])) {
        // Récupération des données envoyées via POST
        $nom = $_POST['lastName'];
        $prenom = $_POST['firstName'];
        $mdp = $_POST['password'];
        $mdpConfirm = $_POST['confirmPassword'];
        $email = $_POST['email']; 
        $telephone = $_POST['phoneNumber'];
        $avatar = $_FILES['image']; 
        $birthDate = $_POST['birthDate'];
        $creation_date = date('Y-m-d H:i:s');  // Date actuelle pour la création
        $last_modified = $creation_date;  // Date actuelle pour la modification
        $isActive = 1;  
        $operator_level = 1;  
        // Hachage du mot de passe pour plus de sécurité
        $mdp_hash = password_hash($mdp, PASSWORD_DEFAULT);

        // Vérification si l'email existe déjà
        $stmt = $db->prepare("SELECT COUNT(*) FROM User WHERE email = :email");
        $stmt->execute(['email' => $email]);

        // Récupération du nombre d'enregistrements correspondant à l'email
        $count = $stmt->fetchColumn();

        // Si l'email existe déjà, afficher un message d'erreur
        if ($count > 0) {
            // Redirection vers la page d'inscription avec un message d'erreur
            return false;
        } else {
            // Si l'email n'existe pas, on procède à l'insertion
            $requete = $db->prepare("INSERT INTO User 
                (id, name, surname, email, phone, avatar, birthDate, creation_date, last_modified, isActive, pass, operator_level) 
                VALUES 
                (0, :name, :surname, :email, :phone, :avatar, :birthDate, :creation_date, :last_modified, :isActive, :pass, :operator_level)");

            // Exécution de la requête avec les paramètres
            $requete->execute(array(
                ":name" => $nom,
                ":surname" => $prenom,
                ":email" => $email,
                ":phone" => $telephone,
                ":avatar" => $avatar,
                ":birthDate" => $birthDate,
                ":creation_date" => $creation_date,
                ":last_modified" => $last_modified,
                ":isActive" => $isActive,
                ":pass" => $mdp_hash,
                ":operator_level" => $operator_level,
            ));

            return true;
        }
    }
}
?>






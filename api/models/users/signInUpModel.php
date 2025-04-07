<?php

// Inclure le fichier de connexion à la base de données
require_once __DIR__ . '/../database.php';

function connection($email = null, $password = null){
    $conn = new connectionDB();
    // Remplacer la préparation/exécution par query()
    $result = $conn->query("SELECT * FROM User WHERE email = :email", [':email' => $email]);

    if($result && count($result) > 0) {
        $user = $result[0];
        if(password_verify($password, $user['pass'])) {
            $conn->close();
            return true;
        }
    } else {
        echo "Error user not found";
        $conn->close();
        return false;
    }
}

function inscription($nom = null, $prenom = null, $mdp = null, $email = null, $telephone = null, $avatar = null, $birthDate = null){
    $conn = new connectionDB();
    $error = ""; // Variable pour stocker les erreurs

    $creation_date = date('Y-m-d H:i:s');
    $last_modified = date('Y-m-d H:i:s', strtotime($creation_date . ' +1 hour'));
    $isActive = 1;  
    $operator_level = 1;  

    // Vérification de l'email existant après les autres validations
    $countResult = $conn->query("SELECT COUNT(*) as cnt FROM User WHERE email = :email", [':email' => $email]);
    $count = $countResult[0]['cnt'];
    if ($count > 0) {
        $conn->close();
        return "EmailAlreadyUsed";
    }

    // Vérification des longueurs d'abord
    if (strlen($email) > 50) {
        $conn->close();
        $error = $error . "1";
    } else {
        $error = $error . "0";
    }
    if (strlen($nom) > 50) {
        $conn->close();
        $error = $error . "1";
    } else {
        $error = $error . "0";
    }
    if (strlen($prenom) > 50) {
        $conn->close();
        $error = $error . "1";
    } else {
        $error = $error . "0";
    }
    if (strlen($telephone) > 50) {
        $conn->close();
        $error = $error . "1";
    } else {
        $error = $error . "0";
    }
    if (strlen($avatar) > 191) {
        $conn->close();
        $error = $error . "1";
    } else {
        $error = $error . "0";
    }


// Vérifications individuelles
if (strlen($mdp) < 8) {
    $error = $error . "1";
}
elseif (!preg_match('/[A-Z]/', $mdp)) {
    $error = $error . "1";
}
elseif (!preg_match('/[0-9]/', $mdp)) {
    $error = $error . "1";
}
elseif (!preg_match('/[!@#$%^&*(),.?":{}|<>]/', $mdp)) {
    $error = $error . "1";
} 

if (!preg_match('/^0+$/', $error)) {
return $error;
}

// Si toutes les vérifications sont passées, hasher le mot de passe et insérer l'utilisateur
$mdp_hash = password_hash($mdp, PASSWORD_DEFAULT);

$conn->query(
    "INSERT INTO User (id, name, surname, email, phone, avatar, birthDate, creation_date, last_modified, isActive, pass, operator_level) 
        VALUES (0, :name, :surname, :email, :phone, :avatar, :birthDate, :creation_date, :last_modified, :isActive, :pass, :operator_level)",
        [
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
        ]
    );
    $conn->close();
    return "success";
}
?>






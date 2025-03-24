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

        $creation_date = date('Y-m-d H:i:s');
        $last_modified = date('Y-m-d H:i:s', strtotime($creation_date . ' +1 hour'));
        $isActive = 1;  
        $operator_level = 1;  

        // Vérification avec query() et COUNT(*)
        $countResult = $conn->query("SELECT COUNT(*) as cnt FROM User WHERE email = :email", [':email' => $email]);
        $count = $countResult[0]['cnt'];
        if ($count > 0) {
            $conn->close();
            return "EmailAlreadyUsed";
        } elseif (strlen($nom)>50) {
            $conn->close();
            return "NameTooLong";
        } elseif (strlen($prenom)>50) {
            $conn->close();
            return "FirstNameTooLong";
        } elseif (strlen($mdp)>255 
                    || strlen($mdp) < 8 // Erreur si mdp inférieur à 8 caractère
                    || !preg_match('/^[A-Z]/', $mdp) // Erreur si la première lettre n'est pas en majuscule
                    || !preg_match('/[\W_]/', $mdp)) // Erreur si le mot de passe ne contient pas de caractère spécial
                    {
            $conn->close();
            return "PasswordTooLong";
        } elseif (strlen($telephone)>50) {
            $conn->close();
            return "PhoneNumberTooLong";
        } elseif (strlen($avatar)>191) {
            $conn->close();
            return "UrlImageTooLong";
        } else {
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
                    ":pass" => $mdp,
                    ":operator_level" => $operator_level,
                ]
            );
            $conn->close();
            return "success";
        }
    }
?>






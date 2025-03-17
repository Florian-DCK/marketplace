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

    if (isset($_POST['ok'])) {
        $nom = $_POST['lastName'];
        $prenom = $_POST['firstName'];
        $mdp = $_POST['password'];
        $mdpConfirm = $_POST['confirmPassword'];
        $email = $_POST['email']; 
        $telephone = $_POST['phoneNumber'];
        $avatar = $_POST['avatar']; 
        $birthDate = $_POST['birthDate'];
        $creation_date = date('Y-m-d H:i:s');
        $last_modified = $creation_date;
        $isActive = 1;  
        $operator_level = 1;  
        $mdp_hash = password_hash($mdp, PASSWORD_DEFAULT);

        // Vérification avec query() et COUNT(*)
        $countResult = $conn->query("SELECT COUNT(*) as cnt FROM User WHERE email = :email", [':email' => $email]);
        $count = $countResult[0]['cnt'];
        if ($count > 0) {
            $conn->close();
            return false;
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
                    ":pass" => $mdp_hash,
                    ":operator_level" => $operator_level,
                ]
            );
            $conn->close();
            return true;
        }
    }
}
?>






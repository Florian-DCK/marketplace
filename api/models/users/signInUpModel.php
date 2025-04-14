<?php

// Inclure le fichier de connexion à la base de données
require_once __DIR__ . '/../database.php';
// Inclure le fichier pour la gestion des images
require_once __DIR__ . '/../images.php';

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

    // Vérification de l'upload de l'image
    if (is_array($avatar) && isset($avatar['tmp_name'])) {
        // Vérifications similaires à imageUploadControllers.php
        $allowed_types = ['image/png', 'image/jpeg', 'image/jpg'];
        $file_type = mime_content_type($avatar['tmp_name']);
        if (!in_array($file_type, $allowed_types)) {
            $conn->close();
            $error = $error . "1";
        } else {
            $image_info = getimagesize($avatar['tmp_name']);
            $width = $image_info[0];
            $height = $image_info[1];
            $max_size = 500;
            if ($width > $max_size || $height > $max_size) {
                $conn->close();
                $error = $error . "1";
            } else {
                $upload_result = image_upload($avatar);
                if ($upload_result && isset($upload_result['link'])) {
                    $avatar = $upload_result['link']; // Stocker le lien de l'image
                    $error = $error . "0";
                } else {
                    $conn->close();
                    $error = $error . "1";
                }
            }
        }
    } else {
        // Si aucun fichier n'est fourni, considérer comme valide (avatar facultatif)
        $avatar = null;
        $error = $error . "0";
    }

    // Vérifications individuelles pour le mot de passe
    if (strlen($mdp) < 8) {
        $error = $error . "1";
    } else {
        $error = $error . "0";
    }
    if (!preg_match('/[A-Z]/', $mdp)) {
        $error = $error . "1";
    } else {
        $error = $error . "0";
    }
    if (!preg_match('/[0-9]/', $mdp)) {
        $error = $error . "1";
    } else {
        $error = $error . "0";
    }
    if (!preg_match('/[!@#$%^&*(),.?":{}|<>]/', $mdp)) {
        $error = $error . "1";
    } else {
        $error = $error . "0";
    }

    // Vérifier si toutes les validations sont passées
    if (!preg_match('/^0+$/', $error)) {
        $conn->close();
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






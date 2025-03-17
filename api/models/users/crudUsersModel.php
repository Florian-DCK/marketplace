<?php

//Sélectionner une catégotie de la table utilisateur
/*$stmt = $db->prepare("SELECT  FROM User WHERE name = :name");
$stmt = $db->prepare("SELECT  FROM User WHERE surname = :surname");
$stmt = $db->prepare("SELECT  FROM User WHERE email = :email");
$stmt = $db->prepare("SELECT  FROM User WHERE phone = :phone");
$stmt = $db->prepare("SELECT  FROM User WHERE avatar = :avatar");
$stmt = $db->prepare("SELECT  FROM User WHERE pass = :pass");

//Modifier une valeur de la table utilisateur
$stmt = $db->prepare("UPDATE User SET name = '' WHERE id = ");
$stmt = $db->prepare("UPDATE User SET surname = '' WHERE id = ");
$stmt = $db->prepare("UPDATE User SET email = '' WHERE id = ");
$stmt = $db->prepare("UPDATE User SET phone =  WHERE id = ");
$stmt = $db->prepare("UPDATE User SET avatar = '' WHERE id = ");
$stmt = $db->prepare("UPDATE User SET pass = '' WHERE id = ");
$stmt = $db->prepare("UPDATE User SET lastModified = NOW() WHERE id = ");

//Changer le statut d'actif pour non-actif (supprimer l'utilisateur)
$stmt = $db->prepare("UPDATE User SET isActive = '' WHERE id = ");
*/

// Inclure le fichier de connexion à la base de données
require_once __DIR__ . '/../database.php';


function updateName($conn, $id, $name) {
    try {
        $conn->db->beginTransaction();
        $conn->query("UPDATE User SET name = :name WHERE id = :id", [
            ":name" => $name,
            ":id" => $id
        ]);
        $conn->query("UPDATE User SET last_modified = NOW() WHERE id = :id", [
            ":id" => $id
        ]);
        $conn->db->commit();
    } catch (Exception $e) {
        $conn->db->rollBack();
        echo "Erreur : " . $e->getMessage();
    }
}

function updateSurname($conn, $id, $surname) {
    try {
        $conn->db->beginTransaction();
        $conn->query("UPDATE User SET surname = :surname WHERE id = :id", [
            ":surname" => $surname,
            ":id" => $id
        ]);
        $conn->query("UPDATE User SET last_modified = NOW() WHERE id = :id", [
            ":id" => $id
        ]);
        $conn->db->commit();
    } catch (Exception $e) {
        $conn->db->rollBack();
        echo "Erreur : " . $e->getMessage();
    }
}

function updateEmail($conn, $email, $id) {
    try {
        $conn->db->beginTransaction();
        $result = $conn->query("SELECT COUNT(*) as cnt FROM User WHERE email = :email", [':email' => $email]);
        $count = $result[0]['cnt'];
        if ($count > 0) {
            header("Location: /../../../api/views/testdb/inscription.php?success=0");
            exit;
        }
        $conn->query("UPDATE User SET email = :email WHERE id = :id", [
            ":email" => $email,
            ":id" => $id
        ]);
        $conn->query("UPDATE User SET last_modified = NOW() WHERE id = :id", [
            ":id" => $id
        ]);
        $conn->db->commit();
    } catch (Exception $e) {
        $conn->db->rollBack();
        echo "Erreur : " . $e->getMessage();
    }
}

function updatePhone($conn, $phone, $id) {
    try {
        $conn->db->beginTransaction();
        $result = $conn->query("SELECT COUNT(*) as cnt FROM User WHERE phone = :phone", ['phone' => $phone]);
        $count = $result[0]['cnt'];
        if ($count > 0) {
            header("Location: /../../../api/views/testdb/inscription.php?success=0");
            exit;
        }
        $conn->query("UPDATE User SET phone = :phone WHERE id = :id", [
            ":phone" => $phone,
            ":id" => $id
        ]);
        $conn->query("UPDATE User SET last_modified = NOW() WHERE id = :id", [
            ":id" => $id
        ]);
        $conn->db->commit();
    } catch (Exception $e) {
        $conn->db->rollBack();
        echo "Erreur : " . $e->getMessage();
    }
}

function updateAvatar($conn, $id, $avatar) {
    try {
        $conn->db->beginTransaction();
        $conn->query("UPDATE User SET avatar = :avatar WHERE id = :id", [
            ":avatar" => $avatar,
            ":id" => $id
        ]);
        $conn->query("UPDATE User SET last_modified = NOW() WHERE id = :id", [
            ":id" => $id
        ]);
        $conn->db->commit();
    } catch (Exception $e) {
        $conn->db->rollBack();
        echo "Erreur : " . $e->getMessage();
    }
}

function updatePass($conn, $id, $mdp) {
    try {
        $conn->db->beginTransaction();
        $mdp_hash = password_hash($mdp, PASSWORD_DEFAULT);
        $conn->query("UPDATE User SET pass = :pass WHERE id = :id", [
            ":pass" => $mdp_hash,
            ":id" => $id
        ]);
        $conn->query("UPDATE User SET last_modified = NOW() WHERE id = :id", [
            ":id" => $id
        ]);
        $conn->db->commit();
    } catch (Exception $e) {
        $conn->db->rollBack();
        echo "Erreur : " . $e->getMessage();
    }
}

?>









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





function updateName($db, $id, $name) {
    try {
        // Démarrer la transaction
        $db->beginTransaction();

        // Mise à jour du nom de l'utilisateur
        $requete = $db->prepare("UPDATE User SET name = :name WHERE id = :id");
        $requete->execute([
            ":name" => $name,
            ":id" => $id
        ]);

        // Mise à jour de la date et de l'heure de modification
        $stmt = $db->prepare("UPDATE User SET last_modified = NOW() WHERE id = :id");
        $stmt->execute([
            ":id" => $id
        ]);

        // Commit de la transaction
        $db->commit();

    } catch (Exception $e) {
        // Si une erreur se produit, on annule la transaction
        $db->rollBack();
        echo "Erreur : " . $e->getMessage();
    }
}





function updateSurname($db, $id, $surname) {
    try {
        // Démarrer la transaction
        $db->beginTransaction();

        // Mise à jour du nom de l'utilisateur
        $requete = $db->prepare("UPDATE User SET surname = :surname WHERE id = :id");
        $requete->execute([
            ":surname" => $surname,
            ":id" => $id
        ]);

        // Mise à jour de la date et de l'heure de modification
        $stmt = $db->prepare("UPDATE User SET last_modified = NOW() WHERE id = :id");
        $stmt->execute([
            ":id" => $id
        ]);

        // Commit de la transaction
        $db->commit();

    } catch (Exception $e) {
        // Si une erreur se produit, on annule la transaction
        $db->rollBack();
        echo "Erreur : " . $e->getMessage();
    }
}




function updateEmail($db, $email, $id) {
    try {
        // Démarrer la transaction
        $db->beginTransaction();

        // Vérifier si l'email existe déjà dans la base de données
        $stmt = $db->prepare("SELECT COUNT(*) FROM User WHERE email = :email");
        $stmt->execute(['email' => $email]);

        // Récupérer le nombre d'enregistrements correspondant à l'email
        $count = $stmt->fetchColumn();

        // Si l'email existe déjà, afficher un message d'erreur
        if ($count > 0) {
            // Redirection vers la page d'inscription avec un message d'erreur
            header("Location: /../../../api/views/testdb/inscription.php?success=0");
            exit;
        }

        // Si l'email n'existe pas, on procède à la mise à jour
        $requete = $db->prepare("UPDATE User SET email = :email WHERE id = :id");
        $requete->execute([
            ":email" => $email,
            ":id" => $id
        ]);

        // Mise à jour de lastModified après l'email
        $stmt = $db->prepare("UPDATE User SET last_modified = NOW() WHERE id = :id");
        $stmt->execute([
            ":id" => $id
        ]);

        // Commit de la transaction
        $db->commit();

    } catch (Exception $e) {
        // Si une erreur se produit, on annule la transaction
        $db->rollBack();
        echo "Erreur : " . $e->getMessage();
    }
}





function updatePhone($db, $phone, $id) {
    try {
        // Démarrer la transaction
        $db->beginTransaction();

        // Vérifier si le téléphone existe déjà dans la base de données
        $stmt = $db->prepare("SELECT COUNT(*) FROM User WHERE phone = :phone");
        $stmt->execute(['phone' => $phone]);

        // Récupérer le nombre d'enregistrements correspondant au téléphone
        $count = $stmt->fetchColumn();

        // Si le téléphone existe déjà, afficher un message d'erreur
        if ($count > 0) {
            // Redirection vers la page d'inscription avec un message d'erreur
            header("Location: /../../../api/views/testdb/inscription.php?success=0");
            exit;
        }

        // Si le téléphone n'existe pas, on procède à la mise à jour
        $requete = $db->prepare("UPDATE User SET phone = :phone WHERE id = :id");
        $requete->execute([
            ":phone" => $phone,
            ":id" => $id
        ]);

        // Mise à jour de la date et heure de modification
        $stmt = $db->prepare("UPDATE User SET last_modified = NOW() WHERE id = :id");
        $stmt->execute([
            ":id" => $id
        ]);

        // Commit de la transaction
        $db->commit();

    } catch (Exception $e) {
        // Si une erreur se produit, on annule la transaction
        $db->rollBack();
        echo "Erreur : " . $e->getMessage();
    }
}





function updateAvatar($db, $id, $avatar) {
    try {
        // Démarrer la transaction
        $db->beginTransaction();

        // Mise à jour du nom de l'utilisateur
        $requete = $db->prepare("UPDATE User SET avatar = :avatar WHERE id = :id");
        $requete->execute([
            ":avatar" => $avatar,
            ":id" => $id
        ]);

        // Mise à jour de la date et de l'heure de modification
        $stmt = $db->prepare("UPDATE User SET last_modified = NOW() WHERE id = :id");
        $stmt->execute([
            ":id" => $id
        ]);

        // Commit de la transaction
        $db->commit();

    } catch (Exception $e) {
        // Si une erreur se produit, on annule la transaction
        $db->rollBack();
        echo "Erreur : " . $e->getMessage();
    }
}




function updatePass($db, $id, $mdp) {
    try {
        // Démarrer la transaction
        $db->beginTransaction();

        // Hacher le mot de passe avant de l'enregistrer
        $mdp_hash = password_hash($mdp, PASSWORD_DEFAULT);

        // Mise à jour du mot de passe de l'utilisateur
        $requete = $db->prepare("UPDATE User SET pass = :pass WHERE id = :id");
        $requete->execute([
            ":pass" => $mdp_hash,
            ":id" => $id
        ]);

        // Mise à jour de la date et de l'heure de modification
        $stmt = $db->prepare("UPDATE User SET last_modified = NOW() WHERE id = :id");
        $stmt->execute([
            ":id" => $id
        ]);

        // Commit de la transaction
        $db->commit();

    } catch (Exception $e) {
        // Si une erreur se produit, on annule la transaction
        $db->rollBack();
        echo "Erreur : " . $e->getMessage();
    }
}





require_once __DIR__ . '/../../../vendor/autoload.php';


$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../../../');
$dotenv->load();


// Récupérer les variables d'environnement
$host    = $_ENV['DB_HOST'];
$port    = $_ENV['DB_PORT'];
$dbname  = $_ENV['DB_NAME'];
$charset = $_ENV['DB_CHARSET'];
$user    = $_ENV['DB_USER'];
$pass    = $_ENV['DB_PASS'];

try {
   $dsn = "mysql:host=$host;port=$port;dbname=$dbname;charset=$charset";
   $db = new PDO($dsn, $user, $pass);
   $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
   echo 'Erreur de connexion : ' . $e->getMessage() . "\n";
   exit;
}





$id = 43; // L'ID de l'utilisateur à mettre à jour
$mdp = "bobo";
// Appeler la fonction pour mettre à jour le nom
updatePass($db, $id, $mdp );
?>









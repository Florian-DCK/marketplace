<?php
    
    // Fonction pour récupérer les informations d'une personne à partir de son email
    function getUserInfo($email) {
        // Inclure le fichier de connexion à la base de données
        require_once __DIR__ . '/db/connect.php';
 
        try {
            // Préparer la requête SQL pour récupérer les informations de l'utilisateur
            $stmt = $db->prepare("SELECT * FROM User WHERE email = :email");
            $stmt->bindParam(':email', $email);
            $stmt->execute();
    
            // Récupérer les résultats de la requête
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
            // Si l'utilisateur existe, renvoyer ses informations
            if ($user) {
                return $user; // Retourne un tableau associatif avec les informations de l'utilisateur
            } else {
                return null; // Si l'utilisateur n'existe pas, retourner null
            }
        } catch (PDOException $e) {
            echo 'Erreur de requête : ' . $e->getMessage();
            return null; // En cas d'erreur, retourner null
        }
    }
?>



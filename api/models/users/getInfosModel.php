<?php

    // Fonction pour récupérer les informations d'une personne à partir de son email

   
    function getUserInfo($email, $db) {
        // Inclure le fichier de connexion à la base de données

        
        try {
            // Préparer la requête SQL pour récupérer les informations de l'utilisateur
            //$stmt = $db->prepare("SELECT * FROM User WHERE email = :email");
            //$stmt->bindParam(':email', $email);
            //$stmt->execute();
    
            // Récupérer les résultats de la requête
            //$user = $stmt->fetch(PDO::FETCH_ASSOC);

            $user  = $db->query("SELECT * FROM User WHERE email = :email", [':email' => $email]);
            
            // Si l'utilisateur existe, renvoyer ses informations
            if ($user) {
                $db->close(); // close connection after successful query
                return $user[0]; // Retourne un tableau associatif avec les informations de l'utilisateur
            } else {
                $db->close(); // close connection even if user not found
                return null; // Si l'utilisateur n'existe pas, retourner null
            }
        } catch (PDOException $e) {
            $db->close(); // close connection on error
            echo 'Erreur de requête : ' . $e->getMessage();
            return null; // En cas d'erreur, retourner null
        }
    }
?>



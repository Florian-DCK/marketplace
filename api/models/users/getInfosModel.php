<?php
    function getUserInfo($email, $db) {
        try {
            $user  = $db->query("SELECT * FROM User WHERE email = :email", [':email' => $email]);
            
            // Si l'utilisateur existe, renvoyer ses informations
            if ($user) {
                $db->close(); 
                return $user[0]; 
            } else {
                $db->close();
                return null;
            }
        } catch (PDOException $e) {
            $db->close(); 
            echo 'Erreur de requête : ' . $e->getMessage();
            return null;
        }
    }
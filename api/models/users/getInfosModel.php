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

    function getIsActive($email, $isActive, $db) {
        try {
            $user  = $db->query("SELECT isActive FROM User WHERE email = :email", [':email' => $email]);
            
            // Si l'utilisateur existe, renvoyer ses informations
            if ($user) {
                $db->close(); 
                return $isActive;
            } else {
                $db->close();
                return null;
            }

            if ($isActive == 1) {
                $db->query("UPDATE User SET isActive = 0 WHERE email = :email", [':email' => $email]);
            } else {
                $db->query("UPDATE User SET isActive = 1 WHERE email = :email", [':email' => $email]);
            }
        } catch (PDOException $e) {
            $db->close(); 
            echo 'Erreur de requête : ' . $e->getMessage();
            return null;
        }
    }

    /*function deleteUser($isActive, $email, $db) {
        try {
            if ($isActive == 1) {
                $db->query("UPDATE User SET isActive = 0 WHERE email = :email", [':email' => $email]);
            } else {
                $db->query("UPDATE User SET isActive = 1 WHERE email = :email", [':email' => $email]);
            }
        } catch (PDOException $e) {
            $db->close(); 
            echo 'Erreur de requête : ' . $e->getMessage();
            return null;
        }

    }*/

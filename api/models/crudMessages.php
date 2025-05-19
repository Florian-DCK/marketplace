<?php

    function sendMessage($id, $id_sender, $id_receiver, $content, $db) {
    try {
            $db->query("INSERT INTO Message (id, id_sender, id_receiver, timestamp = NOW(), content) VALUES (:id, :id_sender, :id_receiver, :timestamp, :content)", [
                ':id' => $id,
                ':id_sender' => $id_sender,
                ':id_receiver' => $id_receiver,
                ':content' => $content
            ]);
        } catch (PDOException $e) {
            echo 'Erreur de requête : ' . $e->getMessage();
            return null;
        }
    }

    function getAllMessages($id_sender, $id_receiver, $db) {
        try {
            $messages = $db->query("SELECT * FROM Message WHERE id_sender = :id_sender AND id_receiver  = :id_receiver)", [
                ':id_sender' => $id_sender,
                ':id_receiver' => $id_receiver
            ]);
            if ($messages) {
                return $messages; 
            } else {
                return null;
            }
        } catch (PDOException $e) {
            echo 'Erreur de requête : ' . $e->getMessage();
            return null;
        }

    }

    function deleteMessage($id, $db) {
        try {
            $db->query("UPDATE Message SET isActive = 0 WHERE id = :id", [
                ':id' => $id
            ]);
        } catch (PDOException $e) {
            echo 'Erreur de requête : ' . $e->getMessage();
            return null;
        }

    }

    function updateMessage($id, $newContent, $db) {
        try {
            $db->query("UPDATE Message SET content = $newContent WHERE id = :id", [
                ':id' => $id
            ]);
        } catch (PDOException $e) {
            echo 'Erreur de requête : ' . $e->getMessage();
            return null;
        }

    }

    function getConversations($id, $db) {
        try {
            $conversations = $db->query("SELECT DISTINCT id_sender, id_receiver FROM Message WHERE id_sender = :id OR id_receiver = :id", [
                ':id' => $id
            ]);
            if ($conversations) {
                return $conversations; 
            } else {
                return null;
            }
        } catch (PDOException $e) {
            echo 'Erreur de requête : ' . $e->getMessage();
            return null;
        }
    }   


?>
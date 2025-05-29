<?php

    function sendMessage($id_sender, $id_receiver, $content, $db) {
    try {
        $db->query("INSERT INTO Message (id_sender, id_receiver, timestamp, content) VALUES (:id_sender, :id_receiver, NOW(), :content)", [
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
            $messages = $db->query(
                "SELECT id, id_sender, id_receiver, timestamp, content, seen, isActive FROM Message 
                WHERE (id_sender = :id1 AND id_receiver = :id2) 
                    OR (id_sender = :id2 AND id_receiver = :id1)
                ORDER BY timestamp ASC",
                [
                    ':id1' => $id_sender,
                    ':id2' => $id_receiver
                ]
            );
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
            $db->query("UPDATE Message SET content = :content WHERE id = :id", [
                ':content' => $newContent,
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
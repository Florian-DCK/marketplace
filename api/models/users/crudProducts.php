<?php

    function getProducts($id, $db) {
        try {
            $products  = $db->query("SELECT * FROM Product WHERE id = :id", [':id' => $id]);
            
            // Si l'article existe, renvoyer ses informations
            if ($products) {
                $db->close(); 
                return $products; 
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

    function updateProduct($id, $name, $description, $image, $price, $isAvalaible, $db) {
        try {
            $db->query("UPDATE Product SET name = :name, description = :description, image = :image, price = :price, isAvalaible = :isAvalaible WHERE id = :id", [
                ':id' => $id,
                ':name' => $name,
                ':description' => $description,
                ':price' => $image,
                ':image' => $price,
                ':quantity' => $isAvalaible
            ]);
        } catch (PDOException $e) {
            $db->close(); 
            echo 'Erreur de requête : ' . $e->getMessage();
            return null;
        }
    }

    function deleteProduct($id, $db) {
        try {
            $db->query("DELETE FROM Product WHERE id = :id", [':id' => $id]);
        } catch (PDOException $e) {
            $db->close(); 
            echo 'Erreur de requête : ' . $e->getMessage();
            return null;
        }
    }

    function createProduct($name, $description, $image, $price, $isAvalaible, $db) {
        try {
            $db->query("INSERT INTO Product (name, description, image, price, isAvalaible) VALUES (:name, :description, :image, :price, :isAvalaible)", [
                ':name' => $name,
                ':description' => $description,
                ':image' => $image,
                ':price' => $price,
                ':isAvalaible' => $isAvalaible
            ]);
        } catch (PDOException $e) {
            $db->close(); 
            echo 'Erreur de requête : ' . $e->getMessage();
            return null;
        }
    }

    $password = "test";

// Variables pour stocker les erreurs
$errors = [];

// Vérifications individuelles
if (strlen($password) < 8) {
    $errors[] = "Le mot de passe doit contenir au moins 8 caractères.";
}
if (!preg_match('/[A-Z]/', $password)) {
    $errors[] = "Le mot de passe doit contenir au moins une majuscule.";
}
if (!preg_match('/[0-9]/', $password)) {
    $errors[] = "Le mot de passe doit contenir au moins un chiffre.";
}
if (!preg_match('/[!@#$%^&*(),.?":{}|<>]/', $password)) {
    $errors[] = "Le mot de passe doit contenir au moins un caractère spécial (!@#$%^&*(),.?\":{}|<>).";
}

// Vérification finale avec le regex complet
$regex = '/^(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#$%^&*(),.?":{}|<>])[A-Za-z0-9!@#$%^&*(),.?":{}|<>]{8,}$/';
if (preg_match($regex, $password)) {
    echo "Mot de passe valide";
} else {
    echo "Mot de passe invalide :<br>";
    foreach ($errors as $error) {
        echo "- " . $error . "<br>";
    }
}
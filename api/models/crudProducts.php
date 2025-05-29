<?php

function checkBasket($user_id, $db) {
        try {
            $basket_id = $db->query("SELECT * FROM Basket WHERE user_id = :user_id", [
                ':user_id' => $user_id
            ]);
            if ($basket_id) {
                return $basket_id; 
            } else {
                try {
                    $db->query("INSERT INTO Basket (user_id) VALUES (:user_id)", [
                        ':user_id' => $user_id
                    ]);
                }
                catch (PDOException $e) {
                    echo 'Erreur de requête : ' . $e->getMessage();
                    return null;
                }
            }
        } catch (PDOException $e) {
            echo 'Erreur de requête : ' . $e->getMessage();
            return null;
        }
    }

    function getProduct($id, $db) {
        try {
            $products  = $db->query("SELECT * FROM Product WHERE id = :id", [':id' => $id]);
            
            // Si l'article existe, renvoyer ses informations
            if ($products) {
                return $products; 
            } else {
                return null;
            }
        } catch (PDOException $e) {

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
            echo 'Erreur de requête : ' . $e->getMessage();
            return null;
        }
    }

    function deleteProduct($id, $db) {
        try {
            $db->query("DELETE FROM Product WHERE id = :id", [':id' => $id]);
        } catch (PDOException $e) {
            echo 'Erreur de requête : ' . $e->getMessage();
            return null;
        }
    }

    function createProduct($id_category, $id_vendor, $name, $description, $image, $price, $db) {
        try {
            $db->query("INSERT INTO Product (id_category, id_vendor, name, description, image, price) VALUES (:id_category, :id_vendor, :name, :description, :image, :price)", [
                ':id_category' => $id_category,
                ':id_vendor' => $id_vendor,
                ':name' => $name,
                ':description' => $description,
                ':image' => $image,
                ':price' => $price,
            ]);
        } catch (PDOException $e) {
            echo 'Erreur de requête : ' . $e->getMessage();
            return null;
        }
    }

    function getProducts($db, $count = null) {
        try {
            if ($count == null) {
                $products  = $db->query("SELECT * FROM Product");
            } else {
                $products  = $db->query("SELECT * FROM Product LIMIT :count", [':count' => $count]);
            }
            
            // Si l'article existe, renvoyer ses informations
            if ($products) {
                return $products; 
            } else {
                return null;
            }
        } catch (PDOException $e) {
            echo 'Erreur de requête : ' . $e->getMessage();
            return null;
        }
    }

    function getHotProducts($db) {
        try {
            $products  = $db->query("SELECT * FROM Product WHERE event = 'Tendance'");
            
            // Si l'article existe, renvoyer ses informations
            if ($products) {
                return $products; 
            } else {
                return null;
            }
        } catch (PDOException $e) {
            $db->close(); 
            echo 'Erreur de requête : ' . $e->getMessage();
            return null;
        }
    }


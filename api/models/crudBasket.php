<?php

    function addBasket($id, $basket_id, $product_id, $quantity ,$db) {
        checkBasket($basket_id, $db);
        try {
                $db->query("INSERT INTO ProductBasket (id, basket_id, product_id, quantity) VALUES (:id, :basket_id, :product_id, :quantity)", [
                    ':id' => $id,
                    ':basket_id' => $basket_id,
                    ':product_id' => $product_id,
                    ':quantity' => $quantity
                ]);
            } catch (PDOException $e) {
                echo 'Erreur de requête : ' . $e->getMessage();
                return null;
            }
    }

    function getBasket($id, $basket_id, $db) {
        checkBasket($basket_id, $db);
        try {
            $productBasket = $db->query("SELECT * FROM ProductBasket WHERE id = :id", [
                ':id' => $id
            ]);
            if ($productBasket) {
                return $productBasket; 
            } else {
                return null;
            }
        } catch (PDOException $e) {
            echo 'Erreur de requête : ' . $e->getMessage();
            return null;
        }
    }

    function clearBasket($id, $basket_id, $db) {
        checkBasket($basket_id, $db);
        try {
            $db->query("DELETE * FROM productBasket WHERE id = :id", [
                ':id' => $id
            ]);
        } catch (PDOException $e) {
            echo 'Erreur de requête : ' . $e->getMessage();
            return null;
        }
    }

    function deleteProduct($product_id,$basket_id ,$db) {
        checkBasket($basket_id, $db);
        try {
            $db->query("DELETE * FROM ProductBasket WHERE product_id = :product_id", [
                ':product_id' => $product_id
            ]);
        } catch (PDOException $e) {
            echo 'Erreur de requête : ' . $e->getMessage();
            return null;
        }
    }

    function updateBasket($id,$basket_id, $newQuantity, $db) {
        checkBasket($basket_id, $db);
        try {
            $db->query("UPDATE ProductBasket SET quantity = :quantity WHERE id = :id", [
                ':id' => $id,
                ':quantity' => $newQuantity
            ]);
        } catch (PDOException $e) {
            echo 'Erreur de requête : ' . $e->getMessage();
            return null;
        }
    }

    function checkBasket($user_id, $db) {
        try {
            $basket = $db->query("SELECT * FROM Basket WHERE user_id = :user_id", [
                ':user_id' => $user_id
            ]);
            if ($basket) {
                return $basket; 
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

?>
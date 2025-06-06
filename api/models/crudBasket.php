<?php

    function addBasket($basket_id, $product_id, $quantity, $db) {
        // Vérifier si le produit est déjà dans le panier
        $existing = $db->query("SELECT * FROM ProductBasket WHERE basket_id = :basket_id AND product_id = :product_id", [
            ':basket_id' => $basket_id,
            ':product_id' => $product_id
        ]);
        if ($existing && isset($existing[0]['quantity'])) {
            // Si déjà présent, on met à jour la quantité
            $newQuantity = $existing[0]['quantity'] + $quantity;
            try {
                $db->query("UPDATE ProductBasket SET quantity = :quantity WHERE basket_id = :basket_id AND product_id = :product_id", [
                    ':quantity' => $newQuantity,
                    ':basket_id' => $basket_id,
                    ':product_id' => $product_id
                ]);
            } catch (PDOException $e) {
                echo 'Erreur de requête : ' . $e->getMessage();
                return null;
            }
        } else {
            // Sinon, on insère
            try {
                $db->query("INSERT INTO ProductBasket (basket_id, product_id, quantity) VALUES (:basket_id, :product_id, :quantity)", [
                    ':basket_id' => $basket_id,
                    ':product_id' => $product_id,
                    ':quantity' => $quantity
                ]);
            } catch (PDOException $e) {
                echo 'Erreur de requête : ' . $e->getMessage();
                return null;
            }
        }
    }

    function getBasket($basket_id, $db) {
        try {
            $productBasket = $db->query("SELECT * FROM ProductBasket WHERE basket_id = :basket_id", [
                ':basket_id' => $basket_id
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

    function clearBasket($basket_id, $db) {
        try {
            $db->query("DELETE * FROM productBasket WHERE basket_id = :basket_id", [
                ':basket_id' => $basket_id
            ]);
        } catch (PDOException $e) {
            echo 'Erreur de requête : ' . $e->getMessage();
            return null;
        }
    }

    function deleteProductFromBasket($product_id, $basket_id ,$db) {
        try {
            $db->query("DELETE * FROM ProductBasket WHERE product_id = :product_id AND WHERE basket_id = :basket_id", [
                ':product_id' => $product_id,
                ':basket_id' => $basket_id
            ]);
        } catch (PDOException $e) {
            echo 'Erreur de requête : ' . $e->getMessage();
            return null;
        }
    }

    function updateBasket($product_id, $basket_id, $newQuantity, $db) {
        try {
            $db->query("UPDATE ProductBasket SET quantity = :quantity 
                        WHERE product_id = :product_id AND basket_id = :basket_id", [
                ':product_id' => $product_id,
                ':basket_id' => $basket_id,
                ':quantity' => $newQuantity
            ]);
        } catch (PDOException $e) {
            throw new Exception('Erreur de requête : ' . $e->getMessage());
        }
    }

    function removeFromBasket($basket_id, $product_id, $db) {
        $sql = "DELETE FROM ProductBasket WHERE basket_id = :basket_id AND product_id = :product_id";
        $stmt = $db->prepare($sql);
        $stmt->execute([
            ':basket_id' => $basket_id,
            ':product_id' => $product_id
        ]);
    }

    /*function checkBasket($user_id, $db) {
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
    }*/

?>
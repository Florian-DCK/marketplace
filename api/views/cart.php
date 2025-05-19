<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Marketplace - Cart</title>
    <link rel="stylesheet" href="/global.css">
</head>

<?php
    require_once __DIR__ . '/../config/session.php';
    include_once __DIR__ . '/../views/navbar.php';
    init_session();
    
    include_once __DIR__ . '/../models/crudBasket.php';

    $mustache = new Mustache_Engine([
        'loader' => new Mustache_Loader_FilesystemLoader(__DIR__ . '/../templates'),
        'partials_loader' => new Mustache_Loader_FilesystemLoader(__DIR__ . '/../templates/partials')
    ]);

    $user_id = $_SESSION['id'] ?? null;
    $quantity = 1;

    if (!$user_id) {
        echo '<p style="color:red">Erreur : utilisateur non connecté. Connectez-vous pour ajouter au panier.</p>';
        exit;
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $product_id = $_POST['product_id'] ?? null;
        $quantity = $_POST['quantity'] ?? 1;

        if ($quantity && $product_id) {
            // Récupérer ou créer le panier de l'utilisateur
            $basket = checkBasket($user_id, $db);
            if ($basket && isset($basket[0]['id'])) {
                $basket_id = $basket[0]['id'];
                // Ajout au panier (id auto-incrémenté, donc non passé)
                addBasket($basket_id, $product_id, $quantity, $db);
            } else {
                echo '<p style="color:red">Erreur : impossible de récupérer le panier utilisateur.</p>';
            }
        } else {
            echo '<p style="color:red">Erreur : données manquantes.</p>';
        }
    }

    echo $mustache->render('cart', []);
    
?>

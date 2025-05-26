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
    include_once __DIR__ . '/../models/crudProducts.php';
    include_once __DIR__ . '/../models/crudBasket.php';
    include_once __DIR__ . '/../models/database.php';

    $mustache = new Mustache_Engine([
        'loader' => new Mustache_Loader_FilesystemLoader(__DIR__ . '/../templates'),
        'partials_loader' => new Mustache_Loader_FilesystemLoader(__DIR__ . '/../templates/partials')
    ]);

    $user_id = $_SESSION['id'] ?? null;
    $basket_id = $_SESSION['basket_id'] ?? null;
    $quantity = 1;

    if (!$user_id) {
        echo '<p style="color:red">Erreur : utilisateur non connecté. Connectez-vous pour ajouter au panier.</p>';
        exit;
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $product_id = $_POST['product_id'] ?? null;
        $quantity = $_POST['quantity'] ?? 1;


        try {
            $db = new connectionDB();
            addBasket($basket_id, $product_id, $quantity, $db);
        } catch (Exception $e) {
            echo '<p style="color:red">Erreur : ' . $e->getMessage() . '</p>';
        }
    }

    $userCart = getBasket($basket_id, $db);
    foreach ($userCart as $key => $item) {
        $product = getProduct($item['product_id'], $db);
        if ($product) {
            $userCart[$key]['product'] = $product[0];
            if ($product[0]['image']) {
                $userCart[$key]['product']['image'] = image_get($product[0]['image'])['link'];
            } else {
                $userCart[$key]['product']['image'] = null;
            }
        } else {
            unset($userCart[$key]);
        }
    }

    $arrayUserCart = ["products" => $userCart];

        var_dump($userCart);

    echo $mustache->render('cart', $arrayUserCart);
    
?>

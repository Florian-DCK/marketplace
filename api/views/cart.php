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
    
    init_session();

    include_once __DIR__ . 'product.php';

    include __DIR__ . '/../models/crudBasket.php';

    $user_id = $_SESSION['user_id'] ?? null;

    if ($_SESSION['REQUEST_METHOD'] === 'POST') {
        $product_id = $_POST['product_id'] ?? null;
        $quantity = $_POST['quantity'] ?? 1;

        if ($quantity && $product_id) {
            addBasket($id, $basket_id, $product_id, $quantity ,$db);
        }
    }

    include __DIR__ . '/navbar.php';

    $mustache = new Mustache_Engine([
        'loader' => new Mustache_Loader_FilesystemLoader(__DIR__ . '/../templates'),
        'partials_loader' => new Mustache_Loader_FilesystemLoader(__DIR__ . '/../templates/partials')
    ]);

    echo $mustache->render('cart');
?>
<?php

require_once __DIR__ . '/../api/models/database.php';
require_once __DIR__ . '/../api/models/users/crudProducts.php';

$db = new connectionDB();

$product = [
    'id_category' => 1,
    'id_vendor' => 1,
    'name' => 'Test Product 1',
    'description' => 'This is the test product 1',
    'image_url' => 'https://example.com/image.jpg',
    'price' => 19.99,
];

createProduct(
    $product['id_category'],
    $product['id_vendor'],
    $product['name'],
    $product['description'],
    $product['image_url'],
    $product['price'],
    $db
);





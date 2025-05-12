<?php
require_once __DIR__ . '/config/session.php';
init_session();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Marketplace</title>
    <link rel="stylesheet" href="/global.css">
</head>
<body class="bg-[#EAEBED] flex flex-col">
    <?php 
    include __DIR__ . '/views/navbar.php'; 
    include __DIR__ . '/models/crudProducts.php';
    include __DIR__ . '/models/database.php';

    $mustache = new Mustache_Engine([
	'loader' => new Mustache_Loader_FilesystemLoader(__DIR__ . '/templates'),
	'partials_loader' => new Mustache_Loader_FilesystemLoader(__DIR__ . '/templates/partials')
    ]);

    $db = new connectionDB();
    $products = getProducts($db);


    $data = [
        'products' => array_map(function($product) {
            return [
                'id' => $product['id'],
                'title' => $product['title'],
                'description' => $product['description'],
                'image' => $product['image'],
                'price' => $product['price'],
                'is_available' => $product['is_available'],
                'fast' => $product['event'] === 'Flash',
                'sales' => $product['event'] === 'Soldes',
                'new' => $product['event'] === 'New',
                'trending' => $product['event'] === 'Tendance',
            ];
        }, $products)
    ];
    ?>
    <div class="flex space-x-5 mx-24 my-4">
        <?php
        echo $mustache->render('card', $data);
        ?>
    </div>  
</body>
</html>

<?php
unset($mustache);
unset($data);
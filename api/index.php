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

    $user_id = $_SESSION['id'] ?? null;
    if ($user_id) {
    checkBasket($user_id, $db);
    }

    $products = getProducts($db);
    foreach ($products as $key => $product) {
        if ($product['image'] ) {
            $products[$key]['image'] = image_get($product['image'])['link'];
        } else {
            $products[$key]['image'] = null;
        }
    }

    $hotProducts = getHotProducts($db);
    if ($hotProducts) {
        foreach ($hotProducts as $key => $product) {
            if ($product['image'] !=null) {
                $hotProducts[$key]['image'] = image_get($product['image'])['link'];
            } else {
                $hotProducts[$key]['image'] = null;
            }
        }
    } else {
        $hotProducts = [];
    }



    $data = [
        'hotProducts' => array_map(function($product) {
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
        }, $hotProducts),
        'products' => array_map(function($product) {
            return [
                'id' => $product['id'],
                'title' => $product['title'],
                'description' => $product['description'],
                'image' => $product['image'],
                'price' => $product['price'],
                'is_available' => $product['is_available'],
                'fast' => $product['event'] === 'Flash',
                'sales' => $product['event'] === 'Sales',
                'new' => $product['event'] === 'New',
                'trending' => $product['event'] === 'Trending',
            ];
        }, $products)
    ];
    ?>
    
        <?php
        echo $mustache->render('productList', $data);
        echo $mustache->render('messages', [
            "Messages" => [
                [
                    'ours' => true,
                    'message' => 'Hello, how can I help you?',
                    'author'=> 'Support',
                    'date' => '12:00',
                ],
                [
                    'ours' => false,
                    'message' => 'I have a question about my order.',
                    'author'=> 'User',
                    'date' => '12:05',
                ],
                [
                    'ours' => true,
                    'message' => 'Sure, what would you like to know?',
                    'author'=> 'Support',
                    'date' => '12:06',
                ]
            ]
        ]);
        ?>
    </div>  
</body>
</html>

<?php
unset($mustache);
unset($data);
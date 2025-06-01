<?php
require_once __DIR__ . '/config/session.php';
include __DIR__ . '/models/users/getInfosModel.php';
require_once __DIR__ . "/models/images.php";
include_once __DIR__ . '/models/database.php';
init_session();

 // supprimer un article
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['deleteArticle'])) {
        $db = new connectionDB();
        $deleteArticle = $_POST['deleteArticle'];
        $db -> query("DELETE FROM Product WHERE id = :id", [':id' => $deleteArticle]);
        header("Location: /");
        exit;
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Marketplace</title>
    <link rel="stylesheet" href="/global.css">
</head>
<body class="bg-[#EAEBED] flex flex-col min-h-screen">
    <?php 
    include __DIR__ . '/views/navbar.php';
    include_once __DIR__ . '/models/crudProducts.php';
    include_once __DIR__ . '/models/database.php';
    
    $db = new connectionDB();

    $user_id = $_SESSION['id'] ?? null;

    $user = null;
    if ($user_id) {
        $email = $_SESSION['email'] ?? null;
        $user = getUserInfo($email, $db);
    }

    $mustache = new Mustache_Engine([
	'loader' => new Mustache_Loader_FilesystemLoader(__DIR__ . '/templates'),
	'partials_loader' => new Mustache_Loader_FilesystemLoader(__DIR__ . '/templates/partials')
    ]);

    $userEmail = isset($_GET['userEmail']) ? $_GET['userEmail'] : '';

    if (!$userEmail){
        $userInfos = $_SESSION ? getUserInfo($_SESSION['email'], $db) : null;
    } else {
        $userInfos = getUserInfo($userEmail, $db);
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
        }, $products),
        'user' => [
            'avatar' => $userInfos['avatar'] ?? '',
        ],
        'userProfileImage' => isset($userInfos['avatar']) && $userInfos['avatar'] ? image_get($userInfos['avatar'])['link'] : '/api/public/defaultAvatar.jpg',
    ];

    

    'isAdmin' => ($_SESSION['operatorLevel'] ?? null) === "administrator",
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
    <div class="flex flex-col w-full px-2 md:px-8 lg:px-24 xl:px-48">
        <?php
        echo $mustache->render('productList', $data);
        include __DIR__ . '/views/messages.php';
        ?>
    </div>  
</body>
</html>

<?php
unset($mustache);
unset($data);
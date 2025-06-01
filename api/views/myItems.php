<?php
require_once __DIR__ . '/../config/session.php';
init_session();

require_once __DIR__ . '/../models/database.php';
require_once __DIR__ . '/../models/crudProducts.php';
require_once __DIR__ . '/../models/users/getInfosModel.php';
require_once __DIR__ . '/../models/images.php';

$mustache = new Mustache_Engine([
    'loader' => new Mustache_Loader_FilesystemLoader(__DIR__ . '/../templates'),
    'partials_loader' => new Mustache_Loader_FilesystemLoader(__DIR__ . '/../templates/partials')
]);

$db = new connectionDB();

$user_id = $_SESSION['id'] ?? null;
$userInfos = $user_id ? getUserInfo($db->query("SELECT email FROM User WHERE id = :id", [':id' => $user_id])[0]['email'], $db) : null;

// Fetch only the products for this user
$userProducts = $user_id ? getUserProducts($db, $user_id) : [];

foreach ($userProducts as $key => $product) {
    if ($product['image']) {
        $userProducts[$key]['image'] = image_get($product['image'])['link'];
    } else {
        $userProducts[$key]['image'] = null;
    }
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Marketplace - My items</title>
    <link rel="stylesheet" href="/global.css">
</head>
<body>


    <?php
        include __DIR__ . '/navbar.php';

        $mustache = new Mustache_Engine([
            'loader' => new Mustache_Loader_FilesystemLoader(__DIR__ . '/../templates'),
            'partials_loader' => new Mustache_Loader_FilesystemLoader(__DIR__ . '/../templates/partials')
        ]);

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
                    'sales' => $product['event'] === 'Sales',
                    'new' => $product['event'] === 'New',
                    'trending' => $product['event'] === 'Trending',
                ];
            }, $userProducts),
            'user' => [
                'avatar' => $userInfos['avatar'] ?? '',
            ],
            'userProfileImage' => isset($userInfos['avatar']) && $userInfos['avatar'] ? image_get($userInfos['avatar'])['link'] : '/api/public/defaultAvatar.jpg',
        ];
    ?>

    <div class="flex flex-col w-full px-2 md:px-8 lg:px-24 xl:px-48">
        <?php
        echo $mustache->render('myItems', $data);
        //include __DIR__ . '../views/messages.php';
        ?>
    </div>



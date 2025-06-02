<?php 
require_once __DIR__ . '/../config/session.php';
init_session();
require __DIR__ . '/../../vendor/autoload.php';
require_once __DIR__ . '/../models/images.php';
include_once __DIR__ . '/../models/database.php';

$mustache = new Mustache_Engine([
	'loader' => new Mustache_Loader_FilesystemLoader(__DIR__ . '/../templates'),
	'partials_loader' => new Mustache_Loader_FilesystemLoader(__DIR__ . '/../templates/partials')
]);

$db = new connectionDB();

$categories = $db->getAllCategoryNames();

$url = $_SERVER['REQUEST_URI'];
$data = [
    'isConnected' =>$_SESSION ? isset($_SESSION['id']) : false ,
	'showCategoryNavbar' => !str_contains($url, 'dashboard'),
	'showMenu' => true,
	'categories' => $categories,
	'menuItems' => [
		['url' => '/dashboard', 'label' => 'My Profile', 'id' => 'user-menu-item-0'],
		['url' => '/myItems', 'label' => 'My items', 'id' => 'user-menu-item-1'],
        ['url' => '/publicationForm', 'label' => 'Post an item', 'id' => 'user-menu-item-2'],
        ['url' => '/cart', 'label' => 'My Cart', 'id' => 'user-menu-item-3'],
		['url' => '/signOut', 'label' => 'Sign Out', 'id' => 'user-menu-item-4'],
		isset($_SESSION['operatorLevel']) && $_SESSION['operatorLevel'] === 'administrator' ? ['url' => '/dashboard/admin', 'label' => 'Admin', 'id' => 'user-menu-item-5'] : null,
	],
    'userName' =>$_SESSION ? $_SESSION['name'] : null ,
    'userProfileImage' => isset($_SESSION['avatar']) && $_SESSION['avatar'] ? image_get($_SESSION['avatar'])['link'] : null,
];

echo $mustache->render('navbar', $data);

unset($mustache);
unset($categories);
unset($url);
unset($data);

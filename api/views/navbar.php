<?php 

if (getenv('VERCEL')) {
    session_save_path('/tmp');
}
session_start();

require __DIR__ . '/../../vendor/autoload.php';

$mustache = new Mustache_Engine([
	'loader' => new Mustache_Loader_FilesystemLoader(__DIR__ . '/../templates'),
	'partials_loader' => new Mustache_Loader_FilesystemLoader(__DIR__ . '/../templates/partials')
]);

$categories = [
    "Food",
    "Tech",
    "Furnitures",
    "Books",
    "Sports",
    "Crafts",
    "Pets",
    "Human slavery",
    "Cars",
    "Clothes",
    "Beauty, healthcare and wellness",
    "Kitchen and houses",
];
$url = $_SERVER['REQUEST_URI'];
$data = [
    'isConnected' =>$_SESSION ? isset($_SESSION['id']) : false ,
	'showCategoryNavbar' => !str_contains($url, 'dashboard'),
	'showMenu' => true,
	'categories' => array_map(function($category) {
		return ['name' => $category];
	}, $categories),
	'menuItems' => [
		['url' => '/dashboard', 'label' => 'Your Profile', 'id' => 'user-menu-item-0'],
		['url' => '/dashboard/admin', 'label' => 'Admin', 'id' => 'user-menu-item-1'],
		['url' => '/signOut', 'label' => 'Sign Out', 'id' => 'user-menu-item-2'],
	],
    'userName' =>$_SESSION ? $_SESSION['name'] : null ,
    'userProfileImage' => '/api/public/defaultAvatar.jpg'
];

var_dump($_SESSION['id']);

echo $mustache->render('navbar', $data);

unset($mustache);
unset($categories);
unset($url);
unset($data);
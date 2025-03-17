
<?php 

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
var_dump ($_SESSION);
$data = [
    'isConnected' =>isset($_SESSION['id']) ,
	'showCategoryNavbar' => !str_contains($url, 'dashboard'),
	'showMenu' => true,
	'categories' => array_map(function($category) {
		return ['name' => $category];
	}, $categories),
	'menuItems' => [
		['url' => '/dashboard', 'label' => 'Your Profile', 'id' => 'user-menu-item-0'],
		['url' => '/dashboard/admin', 'label' => 'Admin', 'id' => 'user-menu-item-1'],
		['url' => '#', 'label' => 'Sign Out', 'id' => 'user-menu-item-2'],
	],
    'userName' => 'John Doe',
    'userProfileImage' => '/api/public/defaultAvatar.jpg'
];

echo $mustache->render('navbar', $data);

unset($mustache);
unset($categories);
unset($url);
unset($data);
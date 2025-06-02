<?php
require_once __DIR__ . '/../config/session.php';
include __DIR__ . '/../models/users/getInfosModel.php';
require_once __DIR__ . "/../models/images.php";
include_once __DIR__ . '/../models/database.php';
include_once __DIR__ . '/../models/crudProducts.php';
init_session();

// Supprimer un article
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['deleteArticle'])) {
    $db = new connectionDB();
    $deleteArticle = $_POST['deleteArticle'];
    $db->query("DELETE FROM Product WHERE id = :id", [':id' => $deleteArticle]);
    header("Location: /");
    exit;
}

// Initialisation de la connexion à la base de données
$db = new connectionDB();

// Gestion de la recherche
$category = isset($_GET['category']) ? trim($_GET['category']) : '';
$search = isset($_GET['query']) ? trim($_GET['query']) : '';
$products = [];
$searchError = null;

if (!empty($category)) {
    $sql = "
        SELECT DISTINCT p.id, p.id_category, p.id_user, p.title, p.description, p.image, p.price, p.is_available, p.event
        FROM Product p
        LEFT JOIN Category c ON p.id_category = c.id
        WHERE c.name = :category
    ";
    try {
        $products = $db->query($sql, [':category' => $category]);
    } catch (Exception $e) {
        $searchError = "Erreur lors de la recherche par catégorie : " . $e->getMessage();
        $products = [];
    }
} elseif (!empty($search)) {
    $sql = "
        SELECT DISTINCT p.id, p.id_category, p.id_user, p.title, p.description, p.image, p.price, p.is_available, p.event
        FROM Product p
        LEFT JOIN Category c ON p.id_category = c.id
        WHERE c.name LIKE :search
        OR p.title LIKE :search
        OR p.description LIKE :search
    ";
    
    try {
        $products = $db->query($sql, [':search' => "%$search%"]);
    } catch (Exception $e) {
        $searchError = "Erreur lors de la recherche : " . $e->getMessage();
        $products = [];
    }
} else {
    try {
        $products = getProducts($db);
    } catch (Exception $e) {
        die("Erreur lors de la récupération des produits : " . $e->getMessage());
    }
}

foreach ($products as $key => $product) {
    if ($product['image']) {
        $products[$key]['image'] = image_get($product['image'])['link'];
    } else {
        $products[$key]['image'] = null;
    }
}

$hotProducts = getHotProducts($db);
if ($hotProducts) {
    foreach ($hotProducts as $key => $product) {
        if ($product['image'] != null) {
            $hotProducts[$key]['image'] = image_get($product['image'])['link'];
        } else {
            $hotProducts[$key]['image'] = null;
        }
    }
} else {
    $hotProducts = [];
}

$user_id = $_SESSION['id'] ?? null;

$user = null;
if ($user_id) {
    $email = $_SESSION['email'] ?? null;
    $user = getUserInfo($email, $db);
}

// Vérification des dossiers de templates
$templatesDir = __DIR__ . '/../templates';
$partialsDir = __DIR__ . '/../templates/partials';
if (!is_dir($templatesDir) || !is_dir($partialsDir)) {
    die("Erreur : Dossier de templates ($templatesDir) ou partials ($partialsDir) introuvable.");
}

try {
    $mustache = new Mustache_Engine([
        'loader' => new Mustache_Loader_FilesystemLoader($templatesDir),
        'partials_loader' => new Mustache_Loader_FilesystemLoader($partialsDir)
    ]);
} catch (Exception $e) {
    die("Erreur lors de l'initialisation de Mustache : " . $e->getMessage());
}

$userEmail = isset($_GET['userEmail']) ? $_GET['userEmail'] : '';

if (!$userEmail) {
    $userInfos = $_SESSION ? getUserInfo($_SESSION['email'], $db) : null;
} else {
    $userInfos = getUserInfo($userEmail, $db);
}

// Ajout de la pagination
$page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
$productsPerPage = 12;
$totalProducts = count($products);
$totalPages = ceil($totalProducts / $productsPerPage);

// Filtrer les produits pour la page actuelle
$startIndex = ($page - 1) * $productsPerPage;
$paginatedProducts = array_slice($products, $startIndex, $productsPerPage);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Marketplace - Recherche</title>
    <link rel="stylesheet" href="/global.css">
</head>
<body class="bg-[#EAEBED] flex flex-col min-h-screen">
    <div class="flex flex-col w-full">
        <?php
        include __DIR__ . '/../views/navbar.php';
        // Vérification des dossiers de templates
        $templatesDir = __DIR__ . '/../templates';
        $partialsDir = __DIR__ . '/../templates/partials';
        if (!is_dir($templatesDir) || !is_dir($partialsDir)) {
            die("Erreur : Dossier de templates ($templatesDir) ou partials ($partialsDir) introuvable.");
        }

        try {
            $mustache = new Mustache_Engine([
                'loader' => new Mustache_Loader_FilesystemLoader($templatesDir),
                'partials_loader' => new Mustache_Loader_FilesystemLoader($partialsDir)
            ]);
        } catch (Exception $e) {
            die("Erreur lors de l'initialisation de Mustache : " . $e->getMessage());
        }

    $data = [
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
            'sales' => $product['event'] === 'Sales',
            'new' => $product['event'] === 'New',
            'trending' => $product['event'] === 'Trending',
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
    }, $paginatedProducts),
    'user' => [
        'avatar' => $userInfos['avatar'] ?? '',
    ],
    'userProfileImage' => isset($userInfos['avatar']) && $userInfos['avatar'] ? image_get($userInfos['avatar'])['link'] : '/api/public/defaultAvatar.jpg',
    'search' => htmlspecialchars($search),
    'hasSearch' => !empty($search),
    'noResults' => empty($products) && !empty($search),
    'searchError' => $searchError,
    'pagination' => [
        'currentPage' => $page,
        'totalPages' => $totalPages,
        'hasPrevious' => $page > 1,
        'hasNext' => $page < $totalPages,
        'previousPage' => $page > 1 ? $page - 1 : null,
        'nextPage' => $page < $totalPages ? $page + 1 : null
    ]
];

        echo $mustache->render('productList', $data);

        include __DIR__ . '/../views/messages.php';
        ?>
    </div>  
</body>
</html>

<?php
unset($mustache);
unset($data);
?>
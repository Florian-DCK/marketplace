<?php
require_once __DIR__ . '/../config/session.php';
init_session();
require_once __DIR__ . '/../models/database.php';

$url = $_SERVER['REQUEST_URI'];

// supprimer un article
$db = new connectionDB();
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['deleteArticle'])) {
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
    <title>Marketplace - Product</title>
    <link rel="stylesheet" href="/global.css">
</head>


    <?php
        include __DIR__ . '/navbar.php';


        $mustache = new Mustache_Engine([
            'loader' => new Mustache_Loader_FilesystemLoader(__DIR__ . '/../templates'),
            'partials_loader' => new Mustache_Loader_FilesystemLoader(__DIR__ . '/../templates/partials')
            ]);


        // Get the product ID from the URL
        $product_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

        if ($product_id > 0) {
            // Fetch the product data along with its category and seller from the database
            $query =   "SELECT Product.*, Category.name AS category_name, User.name AS seller_name, User.phone AS seller_phone, User.email AS seller_email 
                        FROM Product 
                        JOIN Category ON Product.id_category = Category.id  
                        JOIN User ON Product.id_user = User.id
                        WHERE Product.id = :id";
            $product = $db->query($query, [':id' => $product_id]);
            
            // Retrieve the image URL using the image_get function
            if (!empty($product[0]['image'])) {
                $product[0]['image'] = image_get($product[0]['image'])['link'];
            }

            // Render the Mustache template with the product data
            echo $mustache->render('product', [
                'product' => $product[0],
                'current_user' => ['id' =>isset ($_SESSION['id']) ? $_SESSION['id'] : null],
                'canDelete' => (isset($_SESSION['id']) && $_SESSION['id'] == $product[0]['id_user']) || (isset($_SESSION['operatorLevel']) && $_SESSION['operatorLevel'] === 'administrator'),
            ]);
            include_once __DIR__ . '/messages.php';
        } else {
            echo "Product not found.";
        }

   
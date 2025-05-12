<?php

use GrahamCampbell\ResultType\Success;
session_start() ;
require_once __DIR__ . '/../config/session.php';

init_session();

$url = $_SERVER['REQUEST_URI'];

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Marketplace - Publication Form</title>
    <link rel="stylesheet" href="/global.css">
</head>


<<<<<<< HEAD
<?php
    include __DIR__ . '/navbar.php';
    include __DIR__ . '/../models/database.php';

    $mustache = new Mustache_Engine([
        'loader' => new Mustache_Loader_FilesystemLoader(__DIR__ . '/../templates'),
        'partials_loader' => new Mustache_Loader_FilesystemLoader(__DIR__ . '/../templates/partials')
        ]);
=======
    <?php
        include __DIR__ . '/navbar.php';
        include __DIR__ . '/../models/database.php';
        $conn = new connectionDB();
        function getAllCategories($db) {
            try {
                $Category = $db->query("SELECT * FROM Category");
                
                // Si l'article existe, renvoyer ses informations
                if ($Category) {
                   
                    return $Category; 
                } else {
                   
                    return null;
                }
            } catch (PDOException $e) {
                echo 'Erreur de requête : ' . $e->getMessage();
                return null;
            }
    };
    $AllCategories = getAllCategories($conn);
        $mustache = new Mustache_Engine([
            'loader' => new Mustache_Loader_FilesystemLoader(__DIR__ . '/../templates'),
            'partials_loader' => new Mustache_Loader_FilesystemLoader(__DIR__ . '/../templates/partials')
            ]);
            $data = [
                'categories' => $AllCategories,
            ];

            echo $mustache->render('publicationForm', $data);

        
            if ($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_POST)) {
                $id = $_SESSION['id'];
                $title = $_POST['title'];
                $category = $_POST['category'];
                $price = $_POST['price'];
                $image = $_FILES['image'];
                $description = $_POST['description'];

                // Upload l'image et récupère l'ID
                $imageId = image_upload($image);

                var_dump($imageId);

                $conn->query("INSERT INTO Product (id_category, id_user, title, description, price, image) 
                VALUES (:id_category, :id_user, :title, :description, :price, :image)",
                [
                    ":id_category" => $category,
                    ":id_user" => $id, 
                    ":title" => $title,
                    ":description" => $description,
                    ":price" => $price,
                    ":image" => $imageId["id"]  // Utilise l'ID de l'image au lieu de l'array
                ]);
    }

            
            $conn->close();
    ?>
>>>>>>> 5f7d5b287fa6219a7ac89d721c382145d98c9198

        echo $mustache->render('publicationForm');
    
    if (!empty($_POST)) {
        $idVendor = $_SESSION['id'];
        $title = $_POST['title'];
        $idCategory = $_POST['category'];
        $price = $_POST['price'];
        $image = $_FILES['image'];
        $description = $_POST['description'];
    
        $imageResult = image_upload($image);
        if (is_array($imageResult)) {
    
            $conn = new connectionDB();
    
            $conn->query(
                "INSERT INTO Product (id_category, id_vendor, title, description, image, price) 
                VALUES(:id_category,:id_vendor, :title, :description, :image, :price)", 
                [
                    ":id_category" => $idCategory,
                    ":id_vendor" => $idVendor,
                    ":title" => $title,
                    ":description" => $description,
                    ":image" => $image,
                    ":price" => $price
                ]
            );
    
            $conn->close();
            echo "Success";
        }
    }
?>
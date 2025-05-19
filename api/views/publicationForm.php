<?php
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
        
    $messages = [];

    if ($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_POST)) {
        $id = $_SESSION['id'];
        $title = $_POST['title'];
        $category = $_POST['category'] ?? '';
        $price = $_POST['price'];
        $image = $_FILES['image'];
        $description = $_POST['description'];
        $event = $_POST['event'];

        // Validations
        if (empty($title) || strlen($title) > 30 ){
            $messages['title'] = "Titre trop long ou vide.";
        }

        if (empty($price) || !is_numeric($price) || $price < 0) {
            $messages['price'] = "Prix invalide.";
        }

        if (empty($category)) {
            $messages['category'] = "Veuillez choisir une catégorie.";
        }

        if (empty($description) || strlen($description) > 200 ){
            $messages['description'] = "Description trop longue ou vide.";
        }

        if (empty($image)) {
            $messages['image'] = "Veuillez choisir une image.";
        } else {
            $allowedTypes = ['image/jpeg', 'image/png', 'image/jpg'];
            if (!in_array($image['type'], $allowedTypes)) {
                $messages['image'] = "Type de fichier non autorisé.";
            }
        }
        // Si aucune erreur, insère en BDD
        if (empty($messages)) {
            $imageId = image_upload($image);

            $conn->query("INSERT INTO Product (id_category, id_user, title, description, price, image, event) 
                VALUES (:id_category, :id_user, :title, :description, :price, :image, :event)",
                [
                    ":id_category" => $category,
                    ":id_user" => $id, 
                    ":title" => $title,
                    ":description" => $description,
                    ":price" => $price,
                    ":image" => $imageId["id"],
                    "event" => $event
                ]);
            header("Location: index.php");
        }
    }

    $data = [
        'categories' => $AllCategories,
        'messages' => $messages, 
        'event' => $event
    ];

    echo $mustache->render('publicationForm', $data);
    
    $conn->close();
    ?>


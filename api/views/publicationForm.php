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


<?php
    include __DIR__ . '/navbar.php';
    include __DIR__ . '/../models/database.php';

    $mustache = new Mustache_Engine([
        'loader' => new Mustache_Loader_FilesystemLoader(__DIR__ . '/../templates'),
        'partials_loader' => new Mustache_Loader_FilesystemLoader(__DIR__ . '/../templates/partials')
        ]);

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
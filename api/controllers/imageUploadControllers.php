<?php
require_once __DIR__ . '/../models/images.php';

$max_width = 200;  // Largeur maximale en pixels
$max_height = 200; // Hauteur maximale en pixels

$image_width = $image_info[0];  // Largeur de l'image
$image_height = $image_info[1]; // Hauteur de l'image

if (isset($_FILES['image']) && $_FILES['image']['error'] === 0
|| $image_info['mime'] !== 'image/jpeg' 
|| $image_info['mime'] !== 'image/png'
|| $image_width > $max_width 
|| $image_height > $max_height ) {
    
    $image_info = getimagesize($_FILES['image']['tmp_name']);
    if ($image_info === false) {
        echo "Ce fichier n'est pas une image valide.";
        return false;
    }

    if ($image_info['mime'] !== 'image/jpeg' || $image_info['mime'] !== 'image/png') {
        echo "L'image doit être au format JPEG.";
        return false;
    }

    $result = image_upload($_FILES['image']);
    if ($result) {
        return $result;
    } else {
        echo "Erreur lors de l'upload";
        return false;
    }
}


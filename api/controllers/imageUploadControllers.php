<?php
require_once __DIR__ . '/../models/images.php';

if(isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
    // Vérification du type de fichier
    $allowed_types = ['image/png', 'image/jpeg', 'image/jpg'];
    $file_type = mime_content_type($_FILES['image']['tmp_name']);
    
    if(!in_array($file_type, $allowed_types)) {
        echo "Erreur : Seuls les formats PNG et JPEG sont acceptés";
        return false;
    }
    
    // Vérification des dimensions
    $image_info = getimagesize($_FILES['image']['tmp_name']);
    $width = $image_info[0];
    $height = $image_info[1];
    $max_size = 500;
    
    if($width > $max_size || $height > $max_size) {
        echo "Erreur : L'image ne doit pas dépasser 500x500 pixels";
        return false;
    }
    
    // Si toutes les vérifications passent, on procède à l'upload
    $result = image_upload($_FILES['image']);
    if($result) {
        return $result;
    } else {
        echo "Erreur lors de l'upload";
        return false;
    }
}
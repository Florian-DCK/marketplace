<?php
require_once __DIR__ . '/../models/images.php';

if(isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
    $result = image_upload($_FILES['image']);
    if($result) {
        return $result;
    } else {
        echo "Erreur lors de l'upload";
        return false;
    }
}
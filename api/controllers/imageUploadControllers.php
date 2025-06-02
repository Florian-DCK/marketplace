<?php
require_once __DIR__ . '/../models/images.php';

if(isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
    // Vérification du type de fichier
    $allowed_types = ['image/png', 'image/jpeg', 'image/jpg'];
    $file_type = mime_content_type($_FILES['image']['tmp_name']);
    
    if(!in_array($file_type, $allowed_types)) {
        return "format_error";
    }
    
    // Vérification des dimensions
    $image_info = getimagesize($_FILES['image']['tmp_name']);
    $width = $image_info[0];
    $height = $image_info[1];
    $max_size = 500;
    
    if($width > $max_size || $height > $max_size) {
        return "size_error";
    }
    
    // Si toutes les vérifications passent, on procède à l'upload
    $result = image_upload($_FILES['image']);
    // Débogage temporaire pour voir ce que retourne image_upload
    var_dump($result); // À supprimer après inspection
    if($result) {
        // Si $result est un tableau, essayer différentes clés possibles
        if (is_array($result)) {
            if (isset($result['url'])) {
                return $result['url'];
            } elseif (isset($result['path'])) {
                return $result['path'];
            } elseif (isset($result['filename'])) {
                return $result['filename'];
            } else {
                // Si aucune clé connue, retourner la première valeur ou une erreur
                return reset($result) ?: false;
            }
        }
        return $result; // Retourner directement si c'est une chaîne
    } else {
        echo "Erreur lors de l'upload";
        return false;
    }
}
?>
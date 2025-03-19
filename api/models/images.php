<?php
require_once __DIR__ . '/../../vendor/autoload.php';

$isLocal = !getenv('VERCEL_ENV');
            
if ($isLocal) {
    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../../');
    $dotenv->safeLoad();
}

$clientID = getenv('IMGUR_ID') ?: $_ENV['IMGUR_ID'];

$headers = [
    'Authorization: Client-ID ' . $clientID
];

/**
 * Télécharge une image sur Imgur
 * @param {array} $file - Tableau contenant les informations du fichier uploadé ($_FILES)
 * @return {array|boolean} - Tableau avec id, deletehash et lien de l'image si succès, false sinon
 */
function image_upload($file){
    global $headers;
    
    $image = file_get_contents($file['tmp_name']);
    $base64 = base64_encode($image);
    
    $postData = [
        'image' => $base64
    ];
    
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'https://api.imgur.com/3/image');
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    
    $response = curl_exec($ch);
    curl_close($ch);
    
    $result = json_decode($response, true);
    
    if (isset($result['data']['link'])) {
        $result = $result['data'];
        return [
            'id' => $result['id'], 
            'deletehash' => $result['deletehash'], 
            'link' => $result['link']];
    }
    
    return false;
}

/** 
* Récupérer les infos d'une image de Imgur
* @param {string} $imageId - l'id d'une image hosté sur imgur
* @return {array | boolean} $result - Tableau associatif contenant l'id, le deletehash et le lien d'une image si succés, false sinon
*/
function image_get($imageId){
    global $headers;
    
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://api.imgur.com/3/image/$imageId");
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    
    $response = curl_exec($ch);
    
    // Vérifier si l'appel cURL a réussi
    if ($response === false) {
        $error = curl_error($ch);
        curl_close($ch);
        echo "curl raté: " . $error;
        return false;
    }
    
    curl_close($ch);
    
    $result = json_decode($response, true);
    
    // Vérifier si le décodage JSON a réussi
    if (json_last_error() !== JSON_ERROR_NONE) {
        echo "json decode raté";
        return false;
    }
    
    if (isset($result['data'])) {
        $result = $result['data'];
        return [
            'id' => $result['id'], 
            'deletehash' => $result['deletehash'] ?? '', 
            'link' => $result['link']];
    }
    
    return false;
}

/**
 * delete an image hosted on imgur
 * @param {string} $deleteHash - le delete hash de l'image
 * @return bool - true si succés et false sinon
 */
function image_delete($deleteHash){
    global $headers;
    
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://api.imgur.com/3/image/$deleteHash");
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    
    $response = curl_exec($ch);
    
    // Vérifier si l'appel cURL a réussi
    if ($response === false) {
        $error = curl_error($ch);
        curl_close($ch);
        echo "curl raté: " . $error;
        return false;
    }
    curl_close($ch);
    
    $result = json_decode($response, true);
    
    return isset($result['success']) && $result['success'];
}
<?php
require_once __DIR__ . '/../../config/session.php';
require_once __DIR__ . '/../../models/crudBasket.php';
require_once __DIR__ . '/../../models/database.php'; // Ajout de cette ligne
init_session();
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: GET, PUT');
header('Access-Control-Allow-Headers: Content-Type');

// Gérer les requêtes OPTIONS (pre-flight)
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    //Vérifier si l'utilisateur est authentifié
    if (!isset($_SESSION['id'])) {
        http_response_code(401);
        echo json_encode(['error' => 'Non authentifié']);
        exit;
    }


} elseif ($_SERVER['REQUEST_METHOD'] === 'PUT') {
    if (!isset($_SESSION['id'])) {
        http_response_code(401);
        echo json_encode(['error' => 'Non authentifié']);
        exit;
    }

    $data = json_decode(file_get_contents('php://input'), true);
    
    if (!isset($data['product_id']) || !isset($data['quantity'])) {
        http_response_code(400);
        echo json_encode(['error' => 'product_id et quantity requis']);
        exit;
    }

    $product_id = $data['product_id'];
    $basket_id = $_SESSION['basket_id'];
    $quantity = intval($data['quantity']);

    if ($quantity < 0) {
        http_response_code(400);
        echo json_encode(['error' => 'La quantité doit être positive']);
        exit;
    }

    $db = new connectionDB();
    // Mise à jour dans la base de données
    try {
        if ($quantity === 0) {
            deleteProductFromBasket($product_id, $basket_id, $db);
        } else {
            // Mise à jour de la quantité
            updateBasket($product_id, $basket_id, $quantity, $db);
        }
        echo json_encode(['success' => true, 'message' => 'Quantité mise à jour']);
    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode(['error' => 'Erreur lors de la mise à jour : ' . $e->getMessage()]);
    }
} else {
    http_response_code(405);
    echo json_encode(['error' => 'Méthode non autorisée']);
}


<?php
require_once __DIR__ . '/config/session.php';
require_once __DIR__ . '/models/crudBasket.php';

init_session();
$db = new connectionDB();
header('Content-Type: application/json');

$data = json_decode(file_get_contents('php://input'), true);
$productId = $data['product_id'] ?? null;
$basket_id = $_SESSION['basket_id'] ?? null;

if ($productId && $basket_id) {
    
    try {
        removeFromBasket($basket_id, $productId, $db);
        echo json_encode(['success' => true]);
        exit;
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'error' => $e->getMessage()]);
        exit;
    }
}
echo json_encode(['success' => false]);

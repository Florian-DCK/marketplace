<?php
include __DIR__ . '/../../models/database.php';
include __DIR__ . '/../../models/crudMessages.php';
include __DIR__ . '/../../models/users/crudUsersModel.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Vérifier si l'utilisateur est authentifié
    // if (!isset($_SESSION['user_id'])) {
    //     session_start();
    //     http_response_code(401);
    //     echo json_encode(['error' => 'Non authentifié']);
    //     exit;
    // }

    // $userId = $_SESSION['user_id'];
    $userId = $_GET['user_id'] ?? null;
    
    try {
        $db = new connectionDB();
        
        // Récupérer toutes les conversations de l'utilisateur
        $conversations = getConversations($userId, $db);
        
        echo json_encode([
            'success' => true,
            'conversations' => $conversations
        ]);
    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode([
            'error' => 'Erreur serveur: ' . $e->getMessage()
        ]);
    }
} else {
    http_response_code(405);
    echo json_encode(['error' => 'Méthode non autorisée']);
}


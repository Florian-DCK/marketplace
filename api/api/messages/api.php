<?php
include __DIR__ . '/../../models/database.php';
include __DIR__ . '/../../models/messages.php';
include __DIR__ . '/../../models/users.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Vérifier si l'utilisateur est authentifié
    session_start();
    if (!isset($_SESSION['user_id'])) {
        http_response_code(401);
        echo json_encode(['error' => 'Non authentifié']);
        exit;
    }

    $userId = $_SESSION['user_id'];
    
    try {
        $db = new connectionDB();
        
        // Récupérer toutes les conversations de l'utilisateur
        $conversations = $messagesModel->getUserConversations($userId);
        
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


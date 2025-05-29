<?php
include __DIR__ . '/../../models/database.php';
include __DIR__ . '/../../models/crudMessages.php';
include __DIR__ . '/../../models/users/crudUsersModel.php';
require_once __DIR__ . '/../../models/users/getInfosModel.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Vérifier si l'utilisateur est authentifié
    init_session();
    if (!isset($_SESSION['id'])) {
        http_response_code(401);
        echo json_encode(['error' => 'Non authentifié']);
        exit;
    } elseif (!isset($_GET['user_id'])) {
        http_response_code(400);
        echo json_encode(['error' => 'Paramètre user_id manquant']);
        exit;
    } elseif ($_SESSION['id'] != $_GET['user_id']) {
        http_response_code(403);
        echo json_encode(['error' => 'Accès interdit']);
        exit;
    }

    $userId = $_GET['user_id'] ?? null;
    if (isset($_GET['other_user_id'])) {
        $otherUserId = $_GET['other_user_id'];
        if ($userId == $otherUserId) {
            http_response_code(400);
            echo json_encode(['error' => 'Vous ne pouvez pas accéder à vos propres conversations']);
            exit;
        }
        // Vérifier si l'autre utilisateur existe
        $db = new connectionDB();
        $otherUser = getUserById($otherUserId, $db);
        if (!$otherUser) {
            http_response_code(404);
            echo json_encode(['error' => 'Utilisateur non trouvé']);
            exit;
        }

        $messages = getAllMessages($userId, $otherUserId, $db);
        if ($messages === null) {
            http_response_code(500);
            echo json_encode(['error' => 'Erreur lors de la récupération des messages']);
            exit;
        }
        foreach ($messages as &$msg) {
            $msg['ours'] = ($msg['id_sender'] == $_SESSION['id']);
            $msg['date'] = date('d/m/Y H:i', strtotime($msg['timestamp']));
            // $msg['content'] existe déjà, rien à faire ici
        }
        echo json_encode([
            'success' => true,
            'messages' => $messages
        ]);
        exit;
    } else {
        $otherUserId = null;
    }
    
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
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    init_session();
    if (!isset($_SESSION['id'])) {
        http_response_code(401);
        echo json_encode(['error' => 'Non authentifié']);
        exit;
    }
    $data = json_decode(file_get_contents('php://input'), true);
    $userId = $data['user_id'] ?? null;
    $otherUserId = $data['other_user_id'] ?? null;
    $content = trim($data['content'] ?? '');

    if (!$userId || !$otherUserId || !$content) {
        http_response_code(400);
        echo json_encode(['error' => 'Paramètres manquants']);
        exit;
    }
    if ($_SESSION['id'] != $userId) {
        http_response_code(403);
        echo json_encode(['error' => 'Accès interdit']);
        exit;
    }
    if ($userId == $otherUserId) {
        http_response_code(400);
        echo json_encode(['error' => 'Impossible de s\'envoyer un message à soi-même']);
        exit;
    }
    $db = new connectionDB();
    $otherUser = getUserById($otherUserId, $db);
    if (!$otherUser) {
        http_response_code(404);
        echo json_encode(['error' => 'Utilisateur destinataire non trouvé']);
        exit;
    }
    $messageId = uniqid('', true);
    sendMessage($userId, $otherUserId, $content, $db);
    echo json_encode(['success' => true]);
    exit;
} else {
    http_response_code(405);
    echo json_encode(['error' => 'Méthode non autorisée']);
}


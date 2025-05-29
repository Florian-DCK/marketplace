<?php
require_once __DIR__ . '/../config/session.php';
init_session();
require_once __DIR__ . '/../../vendor/autoload.php';
require_once __DIR__ . '/../models/database.php';
require_once __DIR__ . '/../models/crudMessages.php';
require_once __DIR__ . '/../models/users/getInfosModel.php';

if (!isset($_SESSION['id'])) {
    exit;
}

$mustache = new Mustache_Engine([
	'loader' => new Mustache_Loader_FilesystemLoader(__DIR__ . '/../templates'),
	'partials_loader' => new Mustache_Loader_FilesystemLoader(__DIR__ . '/../templates/partials')
]);

$db = new connectionDB();
$conversations = getConversations($_SESSION['id'], $db);
if ($conversations !== null) {
    $uniqueConversations = [];
    foreach ($conversations as &$conversation) {
        $id_sender = $conversation['id_sender'];
        $id_receiver = $conversation['id_receiver'];

        // Identifier l'autre utilisateur dans la conversation
        $otherUserId = ($id_sender == $_SESSION['id']) ? $id_receiver : $id_sender;

        // Utiliser une clé unique pour éviter les doublons
        $key = min($id_sender, $id_receiver) . '-' . max($id_sender, $id_receiver);
        if (!isset($uniqueConversations[$key])) {
            $otherUser = getUserById($otherUserId, $db);
            if ($otherUser) {
                $conversation['sender'] = $otherUser;
                $uniqueConversations[$key] = $conversation;
            }
        }
    }
    $conversations = array_values($uniqueConversations); // Réindexer le tableau
}


echo $mustache->render('messages', [
    'conversations' => $conversations,
    'userId' => $_SESSION['id'],
]);


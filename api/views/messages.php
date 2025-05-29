<?php
require_once __DIR__ . '/../config/session.php';
init_session();
require_once __DIR__ . '/../../vendor/autoload.php';
require_once __DIR__ . '/../models/database.php';
require_once __DIR__ . '/../models/crudMessages.php';

if (!isset($_SESSION['id'])) {
    exit;
}

$mustache = new Mustache_Engine([
	'loader' => new Mustache_Loader_FilesystemLoader(__DIR__ . '/../templates'),
	'partials_loader' => new Mustache_Loader_FilesystemLoader(__DIR__ . '/../templates/partials')
]);

$db = new connectionDB();
$conversations = getConversations($_SESSION['id'], $db);

// var_dump($conversations);



echo $mustache->render('messages', []);


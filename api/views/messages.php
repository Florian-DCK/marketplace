<?php
require_once __DIR__ . '/../config/session.php';
init_session();
require_once __DIR__ . '/../../vendor/autoload.php';

$mustache = new Mustache_Engine([
	'loader' => new Mustache_Loader_FilesystemLoader(__DIR__ . '/../templates'),
	'partials_loader' => new Mustache_Loader_FilesystemLoader(__DIR__ . '/../templates/partials')
]);




echo $mustache->render('messages', [
    "Messages" => [
        [
            'ours' => true,
            'message' => 'Hello, how can I help you?',
            'author'=> 'Support',
            'date' => '12:00',
        ],
        [
            'ours' => false,
            'message' => 'I have a question about my order.',
            'author'=> 'User',
            'date' => '12:05',
        ],
        [
            'ours' => true,
            'message' => 'Sure, what would you like to know?',
            'author'=> 'Support',
            'date' => '12:06',
        ]
    ]
]);


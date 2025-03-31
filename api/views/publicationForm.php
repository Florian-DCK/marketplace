<?php
require_once __DIR__ . '/../config/session.php';
init_session();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Marketplace - Publication Form</title>
    <link rel="stylesheet" href="/global.css">
</head>

<body class="h-screen w-screen flex flex-col bg-[#EAEBED]">
    <?php
        include __DIR__ . '/navbar.php';
        include __DIR__ . '/../models/database.php';

        $mustache = new Mustache_Engine([
            'loader' => new Mustache_Loader_FilesystemLoader(__DIR__ . '/../templates'),
            'partials_loader' => new Mustache_Loader_FilesystemLoader(__DIR__ . '/../templates/partials')
            ]);
    ?>
</body>

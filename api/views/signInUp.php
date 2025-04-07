<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/global.css">  
    <title>Hello World - inscription</title>
</head>
    <?php

    require_once __DIR__ . '/../../vendor/autoload.php';

    $mustache = new Mustache_Engine([
        'loader' => new Mustache_Loader_FilesystemLoader(__DIR__ . '/../templates'),
        'partials_loader' => new Mustache_Loader_FilesystemLoader(__DIR__ . '/../templates/partials')
    ]);

    $data = [
        "inscription" => isset($_GET['login']) ?? $_GET['login'],
    ];

    echo $mustache->render('signInUp', $data);

    ?>
</html>
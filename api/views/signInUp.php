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

    $error = $_GET['error'] ?? null;
    // erreurs positions: email / nom / prénom / téléphone / avatar / mdp 
    var_dump($error);

    if(substr($error, 0,1) == "1") {
        echo "<script>alert('Email is too long');</script>";
    } elseif ( substr($error, 1, 1) == "1" ) {
        echo "<script>alert('Last name is too long');</script>";
    } elseif ( substr($error, 2, 1) == "1" ) {
        echo "<script>alert('First name is too long');</script>";
    } elseif ( substr($error, 3, 1) == "1" ) {
        echo "<script>alert('Phone number is too long');</script>";
    } elseif ( substr($error, 4, 1) == "1" ) {
        echo "<script>alert('Avatar is too long');</script>";
    } elseif ( substr($error, 5, 1) == "1" ) {
        echo "<script>alert('Password is invalid');</script>";
    }



    $data = [
        "inscription" => isset($_GET['login']) ?? $_GET['login'],
    ];

    echo $mustache->render('signInUp', $data);

    ?>
</html>
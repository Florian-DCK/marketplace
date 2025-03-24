<?php
require_once __DIR__ . '/../config/session.php';
init_session();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Marketplace - Dahsboard</title>
    <link rel="stylesheet" href="/global.css">
</head>
<body class="h-screen w-screen flex flex-col bg-[#EAEBED]">
    <?php 
    include __DIR__ . '/navbar.php'; 
    include __DIR__ . '/../models/database.php';

    $url = $_SERVER['REQUEST_URI'];
    
    $mustache = new Mustache_Engine([
	'loader' => new Mustache_Loader_FilesystemLoader(__DIR__ . '/../templates'),
	'partials_loader' => new Mustache_Loader_FilesystemLoader(__DIR__ . '/../templates/partials')
    ]);

        // Variables mockup pour les informations utilisateur
    include __DIR__ . '/../models/users/getInfosModel.php';

    

    ?>
    <main class="flex h-full">
        <?php 
            echo $mustache->render('partials/dashboard/sidebar', $data); 
            echo $mustache->render('partials/dashboard/userInfos', $data);
        ?>
    </main>


</body>
</html>

<?php
unset($url);
unset($mustache);
unset($userEmail);
unset($userInfos);
unset($data);
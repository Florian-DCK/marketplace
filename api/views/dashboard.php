<?php
require_once __DIR__ . '/../config/session.php';
init_session();

if (!isset($_SESSION['id'])) {
    header("Location: /");
    exit;
}

$url = $_SERVER['REQUEST_URI'];

// Vérifier si l'utilisateur est admin (ici, operator_level == 0 indique admin)
if (!isset($_SESSION['operatoLevel']) && $_SESSION['operatorLevel'] !== "administrator" && str_contains($url, 'admin')) {
    header("Location: /dashboard");
    exit;
}
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

    // Récupérer userEmail depuis GET au lieu de POST
    $userEmail = isset($_GET['userEmail']) ? $_GET['userEmail'] : '';

    $db = new connectionDB();

    if (!$userEmail){
        $userInfos = $_SESSION ? getUserInfo($_SESSION['email'], $db) : null;
    } else {
        $userInfos = getUserInfo($userEmail, $db);
    }

    $db->close();
    

    $data = [
        'isAdmin' => str_contains($url, "admin"),
        'user' => [
            'lastName' => $userInfos['surname'] ?? '',
            'firstName' => $userInfos['name'] ?? '',
            'email' => $userInfos['email'] ?? '',
            'phoneNumber' => $userInfos['phone'] ?? '',
            'avatar' => $userInfos['avatar'] ?? '',
            'birthDate' => $userInfos['birthDate'] ?? '',
            'creationDate' => $userInfos['creation_date'] ?? '',
            'lastModified' => $userInfos['last_modified'] ?? '',
            'operatorLevel' => $userInfos['operator_level'] ?? '',
        ]
    ];

    
    ?>
    <main class="flex h-full">
        <?php 
            echo $mustache->render('partials/dashboard/sidebar', $data);
            if (str_contains($url, "admin")){
                echo $mustache->render('partials/dashboard/userAdminInfo', $data);
            } else {
                echo $mustache->render('partials/dashboard/userInfos', $data);
            }
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
?>
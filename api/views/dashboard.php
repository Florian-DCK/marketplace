<?php
require_once __DIR__ . '/../config/session.php';
include __DIR__ . "/../models/users/crudUsersModel.php";
require_once __DIR__ . "/../models/images.php";
init_session();

if (!isset($_SESSION['id'])) {
    header("Location: /");
    exit;
}

$url = $_SERVER['REQUEST_URI'];

// Vérifier si l'utilisateur est admin (ici, operator_level == 0 indique admin)
if (!isset($_SESSION['operatorLevel']) || $_SESSION['operatorLevel'] !== "administrator" && str_contains($url, 'admin')) {
    header("Location: /dashboard");
    exit;
}

if($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $firstName = $_POST['firstName'] ?? '';
    $email = $_POST['email'] ?? '';
    $phone = $_POST['phone'] ?? '';
    $avatar = $_FILES['avatar'] ?? null;
    $password = $_POST['password'] ?? '';
    $confirmPassword = $_POST['confirmPassword'] ?? '';

    if (!empty($_POST['username'])) {
        updateName($db, $_SESSION['id'], $_POST['username']);
    }
    if (!empty($_POST['firstName'])) {
        updateSurname($db, $_SESSION['id'], $_POST['firstName']);
    }
    if (!empty($_POST['email'])) {
        updateEmail($db, $_POST['email'], $_SESSION['id']);
    }
    if (!empty($_POST['phone'])) {
        updatePhone($db, $_POST['phone'], $_SESSION['id']);
    }
    if (!empty($avatar['tmp_name']) && $avatar['error'] === UPLOAD_ERR_OK) {
        $avatar_id = image_upload($avatar)['id'];
        updateAvatar($db, $_SESSION['id'], $avatar_id);
    }
    if (!empty($password) && !empty($confirmPassword) && $password === $confirmPassword) {
        updatePass($db, $_SESSION['id'], $password);
    }

    // erreurs
    if (strlen($email) > 50) {
        echo '<p style="color: red;">Email is too long.</p>';
    }
    if (strlen($username) > 50) {
        echo '<p style="color: red;">Last name is too long.</p>';
    } 
    if (strlen($firstName) > 50) {
        echo '<p style="color: red;">First name is too long.</p>';
    }
    if (strlen($phone) > 50) {
        echo '<p style="color: red;">Phone number is too long.</p>';
    }
    if (!empty($password)) {
    if ($password !== $confirmPassword) {
        echo '<p style="color: red;">Passwords do not match.</p>';
    } else {
        if (strlen($password) < 8) {
            echo '<p style="color: red;">Password must be at least 8 characters long.</p>';
        } elseif (!preg_match('/[A-Z]/', $password)) {
            echo '<p style="color: red;">Password must contain at least one uppercase letter.</p>';
        } elseif (!preg_match('/[0-9]/', $password)) {
            echo '<p style="color: red;">Password must contain at least one number.</p>';
        } elseif (!preg_match('/[!@#$%^&*(),.?":{}|<>]/', $password)) {
            echo '<p style="color: red;">Password must contain at least one special character.</p>';
        } else {
            // Si tout est bon, mise à jour du mot de passe
            updatePass($db, $_SESSION['id'], $password);
        }
    }
}

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
    //require_once __DIR__ . '/../models/database.php';

    $url = $_SERVER['REQUEST_URI'];
    
    $mustache = new Mustache_Engine([
        'loader' => new Mustache_Loader_FilesystemLoader(__DIR__ . '/../templates'),
        'partials_loader' => new Mustache_Loader_FilesystemLoader(__DIR__ . '/../templates/partials')
    ]);

    // Variables mockup pour les informations utilisateur
    include __DIR__ . '/../models/users/getInfosModel.php';

    // Récupérer userEmail depuis GET au lieu de POST
    $userEmail = isset($_GET['userEmail']) ? $_GET['userEmail'] : '';


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
    <main class="flex h-full bg-gradient-to-br bg-[#EAEBED] items-center justify-center px-4">
        <div class="flex mx-auto w-full max-w-7xl rounded-3xl shadow-2xl overflow-hidden bg-white">
            <?php 
                echo $mustache->render('partials/dashboard/sidebar', $data);
                if (str_contains($url, "admin")){
                    echo $mustache->render('partials/dashboard/userAdminInfo', $data);
                } else {
                    echo $mustache->render('partials/dashboard/userInfos', $data);
                }
            ?>
        </div>
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


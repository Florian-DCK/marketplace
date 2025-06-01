<?php
require_once __DIR__ . '/../config/session.php';
include_once __DIR__ . "/../models/users/crudUsersModel.php";
require_once __DIR__ . "/../models/images.php";
require_once __DIR__ . '/../models/database.php';
init_session();

$db = new connectionDB();

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
// récupérer toutes les catagories
$categoryStmt = $db->query("SELECT id, name FROM Category");

// delete une catégorie
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset ($_POST['deleteCategory'])) {
    $deleteCategory = $_POST['deleteCategory'];
    $db->query("DELETE FROM Category WHERE id = :id", [':id' => $deleteCategory]);
    header("Location: /dashboard/admin");
    exit;
}

// ajouter une catégorie
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['addCategory'])) {
    $addCategory = $_POST['addCategory'] ?? '';
    $db->query("INSERT INTO Category (name) VALUES (:name)", [':name' => $addCategory]);
    header("Location: /dashboard/admin");
    exit;
}

// modifier les infos de son compte
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !isset($_POST['modifierUser']) && !isset($_POST['deleteUser']) && !isset($_POST['deleteArticle']) && !isset($_POST['deleteCategory']) && !isset($_POST['addCategory'])) {
    $lastName = $_POST['surname'] ?? '';
    $firstName = $_POST['firstName'] ?? '';
    $email = $_POST['email'] ?? '';
    $phone = $_POST['phone'] ?? '';
    $avatar = $_FILES['avatar'] ?? null;
    $password = $_POST['password'] ?? '';
    $confirmPassword = $_POST['confirmPassword'] ?? '';

    if (!empty($_POST['surname'])) {
        updateSurname($db, $_SESSION['id'], $_POST['surname']);
    }
    if (!empty($_POST['firstName'])) {
        updateName($db, $_SESSION['id'], $_POST['firstName']);
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
    if (strlen($lastName) > 50) {
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

if ($_SERVER['REQUEST_METHOD'] == 'POST' ) {
    // supprimer utilisateur
    if (isset($_POST['deleteUser'])) {
        $deleteUSer = $_POST['deleteUser'];
        $db -> query("DELETE FROM User WHERE email = :email", [':email' => $deleteUSer]);
        header("Location: /dashboard/admin");
        exit;
    }
}

  // modifier user
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['modifierUser'])) {
    $userEmail = $_POST['modifierUser'] ?? '';
    $targetUser = getUserByEmail($db, $userEmail);
    $targetUserId = $targetUser['id'] ?? null;

    if (!$targetUserId) {
        echo '<p style="color: red;">User not found.</p>';
        exit;
    }

    $lastName = $_POST['surname'] ?? '';
    $firstName = $_POST['firstName'] ?? '';
    $email = $_POST['email'] ?? '';
    $phone = $_POST['phone'] ?? '';
    $avatar = $_FILES['avatar'] ?? null;
    $password = $_POST['password'] ?? '';
    $confirmPassword = $_POST['confirmPassword'] ?? '';
    $operatorLevel = $_POST['operatorLevel'] ?? '';

    $hasError = false;
    if (strlen($email) > 50) {
        echo '<p style="color: red;">Email is too long.</p>';
        $hasError = true;
    }
    if (strlen($lastName) > 50) {
        echo '<p style="color: red;">Last name is too long.</p>';
        $hasError = true;
    }
    if (strlen($firstName) > 50) {
        echo '<p style="color: red;">First name is too long.</p>';
        $hasError = true;
    }
    if (strlen($phone) > 50) {
        echo '<p style="color: red;">Phone number is too long.</p>';
        $hasError = true;
    }

    if (!empty($password)) {
        if ($password !== $confirmPassword) {
            echo '<p style="color: red;">Passwords do not match.</p>';
            $hasError = true;
        } elseif (strlen($password) < 8) {
            echo '<p style="color: red;">Password must be at least 8 characters long.</p>';
            $hasError = true;
        } elseif (!preg_match('/[A-Z]/', $password)) {
            echo '<p style="color: red;">Password must contain at least one uppercase letter.</p>';
            $hasError = true;
        } elseif (!preg_match('/[0-9]/', $password)) {
            echo '<p style="color: red;">Password must contain at least one number.</p>';
            $hasError = true;
        } elseif (!preg_match('/[!@#$%^&*(),.?":{}|<>]/', $password)) {
            echo '<p style="color: red;">Password must contain at least one special character.</p>';
            $hasError = true;
        }
    }

    if (!$hasError) {
        if (!empty($lastName)) {
            updateSurname($db, $targetUserId, $lastName);
        }
        if (!empty($firstName)) {
            updateName($db, $targetUserId, $firstName);
        }
        if (!empty($email)) {
            updateEmail($db, $email, $targetUserId);
        }
        if (!empty($phone)) {
            updatePhone($db, $phone, $targetUserId);
        }
        if (!empty($avatar['tmp_name']) && $avatar['error'] === UPLOAD_ERR_OK) {
            $avatar_id = image_upload($avatar)['id'];
            updateAvatar($db, $targetUserId, $avatar_id);
            $_SESSION['avatar'] = $avatar_id; 
        }
        if (!empty($password)) {
            updatePass($db, $targetUserId, $password);
        }

        if (!empty($operatorLevel)) {
            $db->query("UPDATE User SET operator_level = :level WHERE id = :id", [
                ':level' => $operatorLevel,
                ':id' => $targetUserId
            ]);
        }

        echo '<p style="color: green;">User updated successfully.</p>';
    }
}

// rechercher un item
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['searchItem'])) {
    $searchItem = $_POST['searchItem'] ?? '';
    $stmt = $db->query("SELECT * FROM Product WHERE title LIKE :name", [':name' => '%' . $searchItem . '%']);

    $items = [];
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
<body class="w-full flex flex-col bg-[#EAEBED] overflow-x-hidden">
    <?php 
    include_once __DIR__ . '/navbar.php'; 
    
   
    $url = $_SERVER['REQUEST_URI'];
    
    $mustache = new Mustache_Engine([
        'loader' => new Mustache_Loader_FilesystemLoader(__DIR__ . '/../templates'),
        'partials_loader' => new Mustache_Loader_FilesystemLoader(__DIR__ . '/../templates/partials')
    ]);

    // Variables mockup pour les informations utilisateur
    include_once __DIR__ . '/../models/users/getInfosModel.php';

    // Récupérer userEmail depuis GET au lieu de POST
    $userEmail = isset($_GET['userEmail']) ? $_GET['userEmail'] : '';


    if (!$userEmail){
        $userInfos = $_SESSION ? getUserInfo($_SESSION['email'], $db) : null;
    } else {
        $userInfos = getUserInfo($userEmail, $db);
    }

    $db->close();
    
    $categories = [];
    foreach ($categoryStmt as $row) {
        $categories[] = [
            'id' => $row['id'],
            'name' => $row['name']
        ];
    }

    $items = [];
    if (isset($stmt)) {
        foreach ($stmt as $row) {
            $items[] = [
                'id' => $row['id'],
                'title' => $row['title'],
                'description' => $row['description'],
                'price' => $row['price'],
                'image' => $row['image'] ?? '',
            ];
        }
    }
    $data = [
    'isAdmin' => str_contains($url, "admin"),
    'categories' => $categories,
    'items' => $items ,
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
        'isAdmin' => ($userInfos['operator_level'] ?? '') === 'administrator',
        'isUser' => ($userInfos['operator_level'] ?? '') === 'user',
    ],
    ];

    ?>
    <main class="flex h-full bg-gradient-to-br bg-[#EAEBED] items-center justify-center py-8">
        <div class="flex mx-auto w-full max-w-7xl rounded-3xl shadow-2xl overflow-hidden bg-white">
            <?php 
                echo $mustache->render('partials/dashboard/sidebar', $data);
                if (str_contains($url, "admin")){
                    if (str_contains($url, "categories")){
                        echo $mustache->render('partials/dashboard/categories', $data);
                    } else if (str_contains($url, "items")){
                        echo $mustache->render('partials/dashboard/items', $data);
                    } else {
                        echo $mustache->render('partials/dashboard/userAdminInfo', $data);
                    }
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


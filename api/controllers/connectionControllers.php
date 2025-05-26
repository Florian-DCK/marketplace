<?php
require_once __DIR__ . '/../config/session.php';
init_session();
ob_start();

include __DIR__ . "/../models/users/signInUpModel.php";
include __DIR__ . '/../models/users/getInfosModel.php';
require_once __DIR__ . '/../models/database.php';
require_once __DIR__ . '/../models/crudProducts.php';

// Récupérer les valeurs du formulaire
$email = isset($_POST['email']) ? $_POST['email'] : '';
$password = isset($_POST['password']) ? $_POST['password'] : '';

// Appeler la fonction pour récupérer les informations de l'utilisateur
$db = new connectionDB();
$user = getUserInfo($email, $db);

// Vérifier si l'utilisateur existe et si le mot de passe est correct
if ($user && password_verify($password, $user['pass'])) {
    // Stocker les informations de l'utilisateur dans la session
    $_SESSION['id'] = $user['id'];
    $_SESSION['name'] = $user['name'];
    $_SESSION['email'] = $user['email'];
    $_SESSION['surname'] = $user['surname'];
    $_SESSION['avatar'] = $user['avatar'];
    $_SESSION['operatorLevel'] = $user['operator_level'];    
    checkBasket($user['id'], $db);
    $_SESSION['basket_id'] = $db->query("SELECT id FROM Basket WHERE user_id = :user_id", [':user_id' => $user['id']])[0]['id'];
    $db->close();
    
    // Rediriger vers la page d'accueil ou autre
    session_write_close();
    ob_end_clean();
    header("Location: /");
    exit;
} else {
    session_write_close();
    ob_end_clean();
    header("Location: /login?error=InvalidCredentials");
    exit;
}
?>

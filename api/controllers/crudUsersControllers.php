
<?php
/*
require_once __DIR__ . '/../config/session.php';
init_session();

include __DIR__ . "/../models/users/crudUsersModel.php";

$username = $_POST['username'] ?? '';
$firstName = $_POST['firstName'] ?? '';
$email = $_POST['email'] ?? '';
$phone = $_POST['phone'] ?? '';
$avatar = $_FILES['avatar'] ?? null;

$db = new connectionDB();

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
if (!empty($_FILES['avatar'])) {
    $avatar_id = image_upload($avatar)['id'];
    updateAvatar($db, $_SESSION['id'], '$avatar_id');
}



var_dump($_FILES);
*/
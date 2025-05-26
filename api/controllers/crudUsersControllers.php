
<?php
require_once __DIR__ . '/../config/session.php';
init_session();

include __DIR__ . "/../models/users/crudUsersModel.php";
var_dump($_POST);

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
if (!empty($_FILES['avatar']['tmp_name'])) {
    $avatarPath = '/uploads/' . basename($_FILES['avatar']['name']);
    move_uploaded_file($_FILES['avatar']['tmp_name'], __DIR__ . '/../../public' . $avatarPath);
    updateAvatar($db, $_SESSION['id'], $avatarPath);
}


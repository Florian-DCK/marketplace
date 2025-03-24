<?php
require_once __DIR__ . '/../config/session.php';
init_session();
ob_start();

$error = ' ';

function showError($error){
    if (!empty($error)){
        header("location:/");
        echo "Error : autodestruction laucnh";
    }  
}


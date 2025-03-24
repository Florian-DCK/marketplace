<?php
require_once __DIR__ . '/../config/session.php';
init_session();
ob_start();



function showError($error){
    if (!empty($error)){
        header("location:/error");
        echo "Error : ".$error;
    }  
}


<?php
// db_connection.php

try {
    $db = new PDO('mysql:host=51.91.12.160;port=9109;dbname=marketPlaceWorkshop;charset=utf8', 'malacort_antoine', 'lWqUip20QangrHzH');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Connexion réussie à la base de données.\n";
} catch (PDOException $e) {
    echo 'Erreur de connexion : ' . $e->getMessage() . "\n";
    exit;
}
?>
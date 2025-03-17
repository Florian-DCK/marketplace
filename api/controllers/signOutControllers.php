<?php
require_once __DIR__ . '/../config/session.php';
init_session();
session_destroy();

// Rediriger l'utilisateur vers la page d'accueil ou la page de connexion
header("Location: /");
exit;
?>
<?php
session_start();
session_destroy();

// Rediriger l'utilisateur vers la page d'accueil ou la page de connexion
header("Location: /");
exit;
?>
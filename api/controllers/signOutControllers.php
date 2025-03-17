<?php
if (getenv('VERCEL')) {
    session_save_path('/tmp');
}
session_start();
session_destroy();

// Rediriger l'utilisateur vers la page d'accueil ou la page de connexion
header("Location: /");
exit;
?>
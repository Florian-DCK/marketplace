<?php
// Déterminer si nous sommes sur Vercel ou en local
$isVercel = (getenv('VERCEL') === '1') || (strpos($_SERVER['SERVER_SOFTWARE'] ?? '', 'Vercel') !== false);

// Définir la racine du projet selon l'environnement
if ($isVercel) {
    define('PROJECT_ROOT', '/var/task/user');
} else {
    define('PROJECT_ROOT', __DIR__);
}

// Fonction helper pour construire des chemins
function project_path($path = '') {
    return PROJECT_ROOT . ($path ? DIRECTORY_SEPARATOR . ltrim($path, DIRECTORY_SEPARATOR) : '');
}
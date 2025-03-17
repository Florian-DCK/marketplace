<?php
if (!function_exists('init_session')) {
    function init_session() {
        if (session_status() === PHP_SESSION_NONE) {
            // Configuration spécifique pour Vercel
            if (getenv('VERCEL')) {
                ini_set('session.cookie_secure', true);
                ini_set('session.cookie_httponly', true);
                ini_set('session.use_only_cookies', true);
                ini_set('session.cookie_samesite', 'Lax');
                
                // Définir un chemin de sauvegarde accessible et durable
                session_save_path('/tmp/sessions');
                
                // Créer le répertoire s'il n'existe pas
                if (!file_exists('/tmp/sessions')) {
                    mkdir('/tmp/sessions', 0777, true);
                }
            }
            
            // Configuration du cookie pour éviter les problèmes de domaine
            ini_set('session.cookie_path', '/');
            
            // Démarrer la session
            session_start();
        }
    }
}
?>

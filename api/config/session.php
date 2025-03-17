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
                
                if (getenv('REDIS_URL')) {
                    require_once __DIR__ . '/../../vendor/autoload.php';
                    
                    // Utilisation de Predis au lieu de l'extension native
                    $redis = new Predis\Client(getenv('REDIS_URL'));
                    
                    session_set_save_handler(
                        function ($savePath, $sessionName) use ($redis) {
                            return true;
                        },
                        function () {
                            return true;
                        },
                        function ($id) use ($redis) {
                            $data = $redis->get("session:$id");
                            return $data ?: '';
                        },
                        function ($id, $data) use ($redis) {
                            $redis->setex("session:$id", 3600, $data);
                            return true;
                        },
                        function ($id) use ($redis) {
                            $redis->del("session:$id");
                            return true;
                        },
                        function ($maxLifetime) {
                            return true;
                        }
                    );
                } else {
                    // Solution de repli si Redis n'est pas disponible
                    session_save_path('/tmp/sessions');
                    
                    // Créer le répertoire s'il n'existe pas
                    if (!file_exists('/tmp/sessions')) {
                        mkdir('/tmp/sessions', 0777, true);
                    }
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

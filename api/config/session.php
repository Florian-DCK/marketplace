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
                    
                    try {
                        // Connexion avec options pour améliorer la fiabilité
                        $redis = new Predis\Client(getenv('REDIS_URL'), [
                            'read_write_timeout' => 3.0,
                            'reconnect' => true,
                            'timeout' => 5.0
                        ]);
                        
                        // Test de connexion avant de configurer les sessions
                        $redis->ping();
                        
                        session_set_save_handler(
                            function ($savePath, $sessionName) use ($redis) {
                                return true;
                            },
                            function () {
                                return true;
                            },
                            function ($id) use ($redis) {
                                try {
                                    $data = $redis->get("session:$id");
                                    return $data ?: '';
                                } catch (\Exception $e) {
                                    error_log('Session read error: ' . $e->getMessage());
                                    return '';
                                }
                            },
                            function ($id, $data) use ($redis) {
                                try {
                                    $redis->setex("session:$id", 3600, $data);
                                    return true;
                                } catch (\Exception $e) {
                                    error_log('Session write error: ' . $e->getMessage());
                                    return false;
                                }
                            },
                            function ($id) use ($redis) {
                                try {
                                    $redis->del("session:$id");
                                    return true;
                                } catch (\Exception $e) {
                                    error_log('Session delete error: ' . $e->getMessage());
                                    return false;
                                }
                            },
                            function ($maxLifetime) {
                                return true;
                            }
                        );
                        
                        // Enregistrer le handler avec register_shutdown_function
                        // pour éviter les problèmes de ressources fermées
                        register_shutdown_function('session_write_close');
                        
                    } catch (\Exception $e) {
                        error_log('Redis connection error: ' . $e->getMessage());
                        // Fallback au stockage de fichiers si Redis échoue
                        useFallbackSessionStorage();
                    }
                } else {
                    // Solution de repli si Redis n'est pas disponible
                    useFallbackSessionStorage();
                }
            }
            
            // Configuration du cookie pour éviter les problèmes de domaine
            ini_set('session.cookie_path', '/');
            
            // Démarrer la session
            session_start();
        }
    }
    
    function useFallbackSessionStorage() {
        session_save_path('/tmp/sessions');
        
        // Créer le répertoire s'il n'existe pas
        if (!file_exists('/tmp/sessions')) {
            mkdir('/tmp/sessions', 0777, true);
        }
    }
}
?>

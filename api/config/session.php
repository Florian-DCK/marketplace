<?php
if (!function_exists('init_session')) {
    function init_session() {
        if (session_status() === PHP_SESSION_NONE) {
            ini_set('session.cookie_secure', true);
            ini_set('session.cookie_httponly', true);
            ini_set('session.use_only_cookies', true);
            ini_set('session.cookie_samesite', 'Lax');
            ini_set('session.cookie_path', '/');

            require_once __DIR__ . '/../../vendor/autoload.php';
            
            $isLocal = !getenv('VERCEL_ENV');
            
            if ($isLocal) {
                $dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../../');
                $dotenv->safeLoad();
            }
            
            try {
                $redisUrl = getenv('REDIS_URL') ?: $_ENV['REDIS_URL'] ?? 'redis://localhost:6379';
                
                $options = [
                    'read_write_timeout' => 3.0,
                    'reconnect' => true,
                    'timeout' => 5.0
                ];
                
                // Configuration spécifique pour Upstash Redis
                if (strpos($redisUrl, 'upstash.io') !== false) {
                    // Extraire les parties de l'URL Redis
                    $parsedUrl = parse_url($redisUrl);
                    $redisHost = $parsedUrl['host'] ?? '';
                    $redisPort = $parsedUrl['port'] ?? 6379;
                    $redisPassword = $parsedUrl['pass'] ?? '';
                    $redisUser = $parsedUrl['user'] ?? 'default';
                    
                    // Configuration Upstash avec TLS
                    $options['scheme'] = 'tls';
                    $options['ssl'] = ['verify_peer' => false, 'verify_peer_name' => false];
                    
                    // Créer le client avec l'hôte/port et les options
                    $redis = new Predis\Client([
                        'scheme' => 'tls',
                        'host' => $redisHost,
                        'port' => $redisPort,
                        'password' => $redisPassword,
                        'username' => $redisUser
                    ], $options);
                } else {
                    $redis = new Predis\Client($redisUrl, $options);
                }
                
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
                
                register_shutdown_function('session_write_close');

            } catch (\Exception $e) {
                error_log('Redis connection error: ' . $e->getMessage());
                die('Erreur de connexion Redis: ' . $e->getMessage());
            }

            session_start();
        }
    }
}
?>

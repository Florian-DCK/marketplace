<?php
if (!function_exists('init_session')) {
    function init_session() {
        if (session_status() === PHP_SESSION_NONE) {
            if (getenv('VERCEL')) {
                session_save_path('/tmp');
            }
            session_start();
        }
    }
}
?>

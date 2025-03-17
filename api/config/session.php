<?php
if (!function_exists('init_session')) {
    function init_session() {
        if (getenv('VERCEL')) {
            session_save_path('/tmp');
        }
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }
}
?>

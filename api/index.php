<?php
require_once __DIR__ . '/../vendor/autoload.php';

require_once __DIR__ . '/router/router.php';

use Router\Router;

$router = new Router();

$router->register('/api',function() {
    return 'HomePage';
});

$router->register('/contact', function(){
    return 'Contact';
});

echo '<pre>';
var_dump(explode('?', $_SERVER['REQUEST_URI']));
echo '</pre>';

// $router->resolve($_SERVER['REQUEST_URI']);
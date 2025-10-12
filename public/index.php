<?php
/** php -S 127.0.0.0:8000 -t public/ */

if (PHP_MAJOR_VERSION < 8) {
    die('Need php version >= 8');
}

require_once dirname(__DIR__) . '/config/init.php';
require_once dirname(__DIR__) . '/config/bootstrap.php';


$app = new \core\Application();
require_once CONFIG . DS . 'routes.php';
var_dump($app->router->getRoutes());

echo call_user_func($app->router->getRoutes()['POST']['/contact']);


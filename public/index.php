<?php
/** php -S 127.0.0.0:8000 -t public/ */
ini_set('display_errors', 1);

if (PHP_MAJOR_VERSION < 8) {
    die('Need php version >= 8');
}

require_once dirname(__DIR__) . '/config/init.php';
require_once dirname(__DIR__) . '/config/bootstrap.php';


$app = new \core\Application();
require_once CONFIG . DS . 'routes.php';
require_once HELPERS . DS . 'functions.php';
//var_dump($app->router->getRoutes());
//var_dump(app()); exit();

$app->run();


<?php
/** php -S 127.0.0.0:8000 -t public/ */
declare(strict_types=1);
ini_set('display_errors', 1);
error_reporting(-1);
date_default_timezone_set('America/New_York');

if (PHP_MAJOR_VERSION < 8) {
    die('Need php version >= 8');
}

require_once dirname(__DIR__) . '/config/init.php';
require_once dirname(__DIR__) . '/config/bootstrap.php';
require_once HELPERS . DS . 'functions.php';


$app = new \core\Application();
require_once CONFIG . DS . 'routes.php';

$app->run();

if (DEBUG) {
    echo '<div style="margin: 15px; padding: 10px; color: #0f5132; text-align: center;">';
    printf('Source running: %.4F sek', (microtime(true) - $_SERVER['REQUEST_TIME_FLOAT']));
    echo '</div>';
}


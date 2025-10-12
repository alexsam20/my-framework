<?php
/** php -S 127.0.0.0:8000 -t public/ */

if (PHP_MAJOR_VERSION < 8) {
    die('Need php version >= 8');
}

require_once dirname(__DIR__) . '/config/init.php';
require_once dirname(__DIR__) . '/config/bootstrap.php';


var_dump('Testing server!');
var_dump($_SERVER['REQUEST_URI']);
var_dump($_SERVER['QUERY_STRING']);
var_dump($_SERVER['PATH_INFO']);
var_dump($_GET);
var_dump($_SERVER);

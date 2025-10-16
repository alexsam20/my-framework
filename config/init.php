<?php
const DS = DIRECTORY_SEPARATOR;
// ROOT - /media/alex/DataFiles/www/my-framework/
define('ROOT', dirname(__DIR__) . DS);
define('PROTOCOL', strtolower(trim(strstr($_SERVER['SERVER_PROTOCOL'], '/', true))));
// URL ROOt - http://127.0.0.0:8000
define('URL_ROOT', PROTOCOL . '://' . $_SERVER['HTTP_HOST']);
const DEBUG = 1;
const WWW = ROOT . 'public';
const APP = ROOT . 'app';
const CORE = ROOT . 'core';
const HELPERS = ROOT . 'helpers';
const CONFIG = ROOT . 'config';
const VIEWS = APP . DS . 'Views';
const LAYOUT = 'default';
const ERROR_LOG_PATH = ROOT . 'tmp/logs/error.log';
const DB = [
    'host' => 'localhost',
    'dbname' => 'my_framework',
    'username' => 'alex',
    'password' => 'alex1970MD3214',
    'charset' => 'utf8mb4',
    'options' => [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ],
];

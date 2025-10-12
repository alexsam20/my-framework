<?php
// ROOT - /media/alex/DataFiles/www/my-framework
define('ROOT', dirname(__DIR__));
define('PROTOCOL', strtolower(trim(strstr($_SERVER['SERVER_PROTOCOL'], '/', true))));
// URL ROOt - http://127.0.0.0:8000
define('URL_ROOT', PROTOCOL . '://' . $_SERVER['HTTP_HOST']);
echo URL_ROOT;
const DS = DIRECTORY_SEPARATOR;
const WWW = ROOT . DS .'public';
const APP = ROOT . DS .'app';
const CORE = ROOT . DS .'core';
const HELPERS = ROOT . DS .'helpers';
const CONFIG = ROOT . DS .'config';

//require_once ROOT . '/vendor/autoload.php';
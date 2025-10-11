<?php
/** php -S 127.0.0.0:8000 -t public/ */

var_dump('Testing server!');
var_dump($_SERVER['REQUEST_URI']);
var_dump($_SERVER['QUERY_STRING']);
var_dump($_SERVER['PATH_INFO']);
var_dump($_GET);
var_dump($_SERVER);

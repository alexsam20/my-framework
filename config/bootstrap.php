<?php
// Autoloader
spl_autoload_register(static function($class_name) {
    $class_name = str_replace('\\', DS, $class_name);
    if (file_exists(ROOT . DS . $class_name . '.php')) {
        require_once(ROOT . DS . $class_name . '.php');
    }
});
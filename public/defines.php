<?php

define('INDEX', 1);
define('BASEDIR', __DIR__);
define('DB_DNS', 'pgsql:');

function __autoload($class) {
    $class = strtr($class, '\\', '/');
    $file = BASEDIR . "/{$class}.php";
    if (file_exists($file)) {
        require_once $file;
    }
}

//DEBUG
ini_set('display_startup_errors',1);
ini_set('display_errors',1);
error_reporting(-1);
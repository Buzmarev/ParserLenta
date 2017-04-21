<?php

function my_autoloader($class) {
    $path_arr = [
        '/components/',
        '/models/'
    ];
    
    foreach ($path_arr as $path) {
        $path = ROOT. $path. $class. '.php';
        if (is_file($path)) {
            include_once $path;
        }
    }
}

spl_autoload_register('my_autoloader');

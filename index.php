<?php

define('ROOT', dirname(__FILE__));

include_once(ROOT. '/vendor/autoload.php');
include_once(ROOT. '/components/Autoload.php');

$router = new Router;
$router -> run();

<?php

if (!defined('DS')) {
    define('DS', DIRECTORY_SEPARATOR);
}
if (!defined('ROOT')) {
    require_once dirname(__DIR__) . DS . 'config' . DS . 'paths.php';
}
require_once ROOT . DS . 'vendor' . DS . 'autoload.php';

$app = new App\Application(CONFIG);
$server = new Cake\Http\Server($app);
$server->emit($server->run());
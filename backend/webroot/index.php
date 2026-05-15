<?php
// Garante a constante DS (Directory Separator)
if (!defined('DS')) {
    define('DS', DIRECTORY_SEPARATOR);
}


require dirname(__DIR__) . '/vendor/autoload.php';

$app = new App\Application(CONFIG);
$server = new Cake\Http\Server($app);
$server->emit($server->run());
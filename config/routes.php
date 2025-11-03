<?php
use Cake\Routing\Route\DashedRoute;
use Cake\Routing\RouteBuilder;

return function (RouteBuilder $routes): void {
    $routes->setRouteClass(DashedRoute::class);

    $routes->scope('/', function (RouteBuilder $builder): void {
        $builder->connect('/', ['controller' => 'Users', 'action' => 'login', 'home']);
        $builder->connect('/pages/', 'Pages::display');

        // Rotas de Users
        $builder->connect('/login', ['controller' => 'Users', 'action' => 'login']);
        $builder->connect('/logout', ['controller' => 'Users', 'action' => 'logout']);
        $builder->connect('/register', ['controller' => 'Users', 'action' => 'add']);
        $builder->connect('/forgot-password', ['controller' => 'Users', 'action' => 'forgotPassword']);
        $builder->connect('/reset-password/', ['controller' => 'Users', 'action' => 'resetPassword']);

        // NOVAS ROTAS DE FLASHCARDS - SEM CONFLITO
        $builder->connect('/flashcards', ['controller' => 'Flashcards', 'action' => 'listar']);
        $builder->connect('/flashcards/criar', ['controller' => 'Flashcards', 'action' => 'criar']);
        $builder->connect('/flashcards/ver/', ['controller' => 'Flashcards', 'action' => 'ver']);
        $builder->connect('/flashcards/editar/', ['controller' => 'Flashcards', 'action' => 'editar']);
        $builder->connect('/flashcards/excluir/*', ['controller' => 'Flashcards', 'action' => 'excluir']);

        $builder->fallbacks();
    });
};
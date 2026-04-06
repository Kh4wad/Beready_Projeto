<?php
declare(strict_types=1);

use Cake\Routing\Route\DashedRoute;
use Cake\Routing\RouteBuilder;

/** @var \Cake\Routing\RouteBuilder $routes */
$routes->setRouteClass(DashedRoute::class);

// Rotas simples e diretas
$routes->connect('/health', ['controller' => 'Users', 'action' => 'health']);
$routes->connect('/auth/register', ['controller' => 'Users', 'action' => 'register']);
$routes->connect('/auth/login', ['controller' => 'Users', 'action' => 'login']);
$routes->connect('/auth/logout', ['controller' => 'Users', 'action' => 'logout']);

// Rotas com parâmetros
$routes->connect('/users/view/{id}', ['controller' => 'Users', 'action' => 'view'])
    ->setPatterns(['id' => '\d+'])
    ->setMethods(['GET']);

$routes->connect('/users/update/{id}', ['controller' => 'Users', 'action' => 'update'])
    ->setPatterns(['id' => '\d+'])
    ->setMethods(['PUT', 'POST']);

$routes->connect('/users/delete/{id}', ['controller' => 'Users', 'action' => 'delete'])
    ->setPatterns(['id' => '\d+'])
    ->setMethods(['DELETE']);

// ============================================
// FLASHCARDS ROUTES
// ============================================

// Listar todos
$routes->connect('/flashcards', ['controller' => 'Flashcards', 'action' => 'index'])->setMethods(['GET']);

// Criar
$routes->connect('/flashcards', ['controller' => 'Flashcards', 'action' => 'add'])->setMethods(['POST']);

// Buscar um (rota alternativa sem /view/)
$routes->connect('/flashcards/{id}', ['controller' => 'Flashcards', 'action' => 'view'])
    ->setPatterns(['id' => '\d+'])
    ->setMethods(['GET']);

// Buscar um (rota com /view/)
$routes->connect('/flashcards/view/{id}', ['controller' => 'Flashcards', 'action' => 'view'])
    ->setPatterns(['id' => '\d+'])
    ->setMethods(['GET']);

// Atualizar (rota alternativa sem /edit/)
$routes->connect('/flashcards/{id}', ['controller' => 'Flashcards', 'action' => 'edit'])
    ->setPatterns(['id' => '\d+'])
    ->setMethods(['PUT']);

// Atualizar (rota com /edit/)
$routes->connect('/flashcards/edit/{id}', ['controller' => 'Flashcards', 'action' => 'edit'])
    ->setPatterns(['id' => '\d+'])
    ->setMethods(['PUT']);

// Deletar (rota alternativa sem /delete/)
$routes->connect('/flashcards/{id}', ['controller' => 'Flashcards', 'action' => 'delete'])
    ->setPatterns(['id' => '\d+'])
    ->setMethods(['DELETE']);

// Deletar (rota com /delete/)
$routes->connect('/flashcards/delete/{id}', ['controller' => 'Flashcards', 'action' => 'delete'])
    ->setPatterns(['id' => '\d+'])
    ->setMethods(['DELETE']);

// ============================================
// QUIZES ROUTES
// ============================================

// Listar todos
$routes->connect('/quizes', ['controller' => 'Quizes', 'action' => 'index'])->setMethods(['GET']);

// Criar
$routes->connect('/quizes', ['controller' => 'Quizes', 'action' => 'add'])->setMethods(['POST']);

// Buscar um (rota alternativa sem /view/)
$routes->connect('/quizes/{id}', ['controller' => 'Quizes', 'action' => 'view'])
    ->setPatterns(['id' => '\d+'])
    ->setMethods(['GET']);

// Buscar um (rota com /view/)
$routes->connect('/quizes/view/{id}', ['controller' => 'Quizes', 'action' => 'view'])
    ->setPatterns(['id' => '\d+'])
    ->setMethods(['GET']);

// Atualizar (rota alternativa sem /edit/)
$routes->connect('/quizes/{id}', ['controller' => 'Quizes', 'action' => 'edit'])
    ->setPatterns(['id' => '\d+'])
    ->setMethods(['PUT']);

// Atualizar (rota com /edit/)
$routes->connect('/quizes/edit/{id}', ['controller' => 'Quizes', 'action' => 'edit'])
    ->setPatterns(['id' => '\d+'])
    ->setMethods(['PUT']);

// Deletar (rota alternativa sem /delete/)
$routes->connect('/quizes/{id}', ['controller' => 'Quizes', 'action' => 'delete'])
    ->setPatterns(['id' => '\d+'])
    ->setMethods(['DELETE']);

// Deletar (rota com /delete/)
$routes->connect('/quizes/delete/{id}', ['controller' => 'Quizes', 'action' => 'delete'])
    ->setPatterns(['id' => '\d+'])
    ->setMethods(['DELETE']);

// Fallback
$routes->connect('/*', ['controller' => 'Users', 'action' => 'notFound']);
<?php
declare(strict_types=1);

use Cake\Routing\Route\DashedRoute;
use Cake\Routing\RouteBuilder;

/** @var \Cake\Routing\RouteBuilder $routes */
$routes->setRouteClass(DashedRoute::class);

/**
 * ============================================================
 * HEALTHCHECK
 * ============================================================
 */
$routes->connect('/health', [
    'controller' => 'Users',
    'action' => 'health'
])->setMethods(['GET']);

/**
 * ============================================================
 * AUTH ROUTES
 * ============================================================
 */
$routes->connect('/auth/register', [
    'controller' => 'Users',
    'action' => 'register'
])->setMethods(['POST']);

$routes->connect('/auth/login', [
    'controller' => 'Users',
    'action' => 'login'
])->setMethods(['POST']);

$routes->connect('/auth/logout', [
    'controller' => 'Users',
    'action' => 'logout'
])->setMethods(['POST']);

$routes->connect('/auth/forgot-password', [
    'controller' => 'Users',
    'action' => 'forgotPassword'
])->setMethods(['POST']);

$routes->connect('/auth/reset-password/{token}', [
    'controller' => 'Users',
    'action' => 'resetPassword'
])->setPatterns([
    'token' => '[a-f0-9]{64}'
])->setMethods(['POST']);

/**
 * ============================================================
 * USERS (UUID FIRST + ID FALLBACK)
 * ============================================================
 */
$routes->connect('/users/{uuid}', [
    'controller' => 'Users',
    'action' => 'viewByUuid'
])->setPatterns([
    'uuid' => '[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}'
])->setMethods(['GET']);

// fallback ID
$routes->connect('/users/{id}', [
    'controller' => 'Users',
    'action' => 'view'
])->setPatterns(['id' => '\d+'])->setMethods(['GET']);

$routes->connect('/users/update/{id}', [
    'controller' => 'Users',
    'action' => 'update'
])->setPatterns(['id' => '\d+'])->setMethods(['PUT', 'POST']);

$routes->connect('/users/delete/{id}', [
    'controller' => 'Users',
    'action' => 'delete'
])->setPatterns(['id' => '\d+'])->setMethods(['DELETE']);

/**
 * ============================================================
 * FLASHCARDS (REST CLEAN)
 * ============================================================
 */
$routes->connect('/flashcards', [
    'controller' => 'Flashcards',
    'action' => 'index'
])->setMethods(['GET']);

$routes->connect('/flashcards', [
    'controller' => 'Flashcards',
    'action' => 'add'
])->setMethods(['POST']);

// UUID view
$routes->connect('/flashcards/{uuid}', [
    'controller' => 'Flashcards',
    'action' => 'viewByUuid'
])->setPatterns([
    'uuid' => '[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}'
])->setMethods(['GET']);

// fallback ID view
$routes->connect('/flashcards/{id}', [
    'controller' => 'Flashcards',
    'action' => 'view'
])->setPatterns(['id' => '\d+'])->setMethods(['GET']);

$routes->connect('/flashcards/{id}', [
    'controller' => 'Flashcards',
    'action' => 'edit'
])->setPatterns(['id' => '\d+'])->setMethods(['PUT']);

$routes->connect('/flashcards/{id}', [
    'controller' => 'Flashcards',
    'action' => 'delete'
])->setPatterns(['id' => '\d+'])->setMethods(['DELETE']);

/**
 * ============================================================
 * QUIZES (REST)
 * ============================================================
 */
$routes->connect('/quizes', [
    'controller' => 'Quizes',
    'action' => 'index'
])->setMethods(['GET']);

$routes->connect('/quizes', [
    'controller' => 'Quizes',
    'action' => 'add'
])->setMethods(['POST']);

$routes->connect('/quizes/{id}', [
    'controller' => 'Quizes',
    'action' => 'view'
])->setPatterns(['id' => '\d+'])->setMethods(['GET']);

$routes->connect('/quizes/{id}', [
    'controller' => 'Quizes',
    'action' => 'edit'
])->setPatterns(['id' => '\d+'])->setMethods(['PUT']);

$routes->connect('/quizes/{id}', [
    'controller' => 'Quizes',
    'action' => 'delete'
])->setPatterns(['id' => '\d+'])->setMethods(['DELETE']);

/**
 * ============================================================
 * TAGS
 * ============================================================
 */
$routes->connect('/tags', [
    'controller' => 'Tags',
    'action' => 'index'
])->setMethods(['GET']);

$routes->connect('/tags', [
    'controller' => 'Tags',
    'action' => 'add'
])->setMethods(['POST']);

$routes->connect('/tags/{id}', [
    'controller' => 'Tags',
    'action' => 'view'
])->setPatterns(['id' => '\d+'])->setMethods(['GET']);

$routes->connect('/tags/{id}', [
    'controller' => 'Tags',
    'action' => 'edit'
])->setPatterns(['id' => '\d+'])->setMethods(['PUT']);

$routes->connect('/tags/{id}', [
    'controller' => 'Tags',
    'action' => 'delete'
])->setPatterns(['id' => '\d+'])->setMethods(['DELETE']);

$routes->connect('/tags/usuario/{usuarioId}', [
    'controller' => 'Tags',
    'action' => 'getByUsuario'
])->setPatterns(['usuarioId' => '\d+'])->setMethods(['GET']);

/**
 * ============================================================
 * PREFERÊNCIAS
 * ============================================================
 */
$routes->connect('/preferencias/usuario/{usuarioId}', [
    'controller' => 'Preferencias',
    'action' => 'getByUsuario'
])->setPatterns(['usuarioId' => '\d+'])->setMethods(['GET']);

$routes->connect('/preferencias', [
    'controller' => 'Preferencias',
    'action' => 'save'
])->setMethods(['POST']);

/**
 * ============================================================
 * PROGRESSO
 * ============================================================
 */
$routes->connect('/progresso/usuario/{usuarioId}', [
    'controller' => 'Progresso',
    'action' => 'getByUsuario'
])->setPatterns(['usuarioId' => '\d+'])->setMethods(['GET']);

$routes->connect('/progresso', [
    'controller' => 'Progresso',
    'action' => 'save'
])->setMethods(['POST']);

/**
 * ============================================================
 * PROMPTS
 * ============================================================
 */
$routes->connect('/prompts', [
    'controller' => 'Prompts',
    'action' => 'index'
])->setMethods(['GET']);

$routes->connect('/prompts', [
    'controller' => 'Prompts',
    'action' => 'add'
])->setMethods(['POST']);

$routes->connect('/prompts/{id}', [
    'controller' => 'Prompts',
    'action' => 'view'
])->setPatterns(['id' => '\d+'])->setMethods(['GET']);

$routes->connect('/prompts/{id}', [
    'controller' => 'Prompts',
    'action' => 'edit'
])->setPatterns(['id' => '\d+'])->setMethods(['PUT']);

$routes->connect('/prompts/{id}', [
    'controller' => 'Prompts',
    'action' => 'delete'
])->setPatterns(['id' => '\d+'])->setMethods(['DELETE']);

$routes->connect('/prompts/usuario/{usuarioId}', [
    'controller' => 'Prompts',
    'action' => 'getByUsuario'
])->setPatterns(['usuarioId' => '\d+'])->setMethods(['GET']);

/**
 * ============================================================
 * TRADUÇÕES
 * ============================================================
 */
$routes->connect('/traducoes/{id}', [
    'controller' => 'Traducoes',
    'action' => 'view'
])->setPatterns(['id' => '\d+'])->setMethods(['GET']);

$routes->connect('/traducoes', [
    'controller' => 'Traducoes',
    'action' => 'add'
])->setMethods(['POST']);

$routes->connect('/traducoes/{id}', [
    'controller' => 'Traducoes',
    'action' => 'edit'
])->setPatterns(['id' => '\d+'])->setMethods(['PUT']);

$routes->connect('/traducoes/{id}', [
    'controller' => 'Traducoes',
    'action' => 'delete'
])->setPatterns(['id' => '\d+'])->setMethods(['DELETE']);

$routes->connect('/traducoes/prompt/{promptId}', [
    'controller' => 'Traducoes',
    'action' => 'getByPrompt'
])->setPatterns(['promptId' => '\d+'])->setMethods(['GET']);

/**
 * ============================================================
 * IMAGENS GERADAS
 * ============================================================
 */
$routes->connect('/imagens/{id}', [
    'controller' => 'ImagensGeradas',
    'action' => 'view'
])->setPatterns(['id' => '\d+'])->setMethods(['GET']);

$routes->connect('/imagens', [
    'controller' => 'ImagensGeradas',
    'action' => 'add'
])->setMethods(['POST']);

$routes->connect('/imagens/{id}', [
    'controller' => 'ImagensGeradas',
    'action' => 'edit'
])->setPatterns(['id' => '\d+'])->setMethods(['PUT']);

$routes->connect('/imagens/{id}', [
    'controller' => 'ImagensGeradas',
    'action' => 'delete'
])->setPatterns(['id' => '\d+'])->setMethods(['DELETE']);

$routes->connect('/imagens/prompt/{promptId}', [
    'controller' => 'ImagensGeradas',
    'action' => 'getByPrompt'
])->setPatterns(['promptId' => '\d+'])->setMethods(['GET']);

/**
 * ============================================================
 * FRASES SEMELHANTES
 * ============================================================
 */
$routes->connect('/frases/{id}', [
    'controller' => 'FrasesSemelhantes',
    'action' => 'view'
])->setPatterns(['id' => '\d+'])->setMethods(['GET']);

$routes->connect('/frases', [
    'controller' => 'FrasesSemelhantes',
    'action' => 'add'
])->setMethods(['POST']);

$routes->connect('/frases/{id}', [
    'controller' => 'FrasesSemelhantes',
    'action' => 'edit'
])->setPatterns(['id' => '\d+'])->setMethods(['PUT']);

$routes->connect('/frases/{id}', [
    'controller' => 'FrasesSemelhantes',
    'action' => 'delete'
])->setPatterns(['id' => '\d+'])->setMethods(['DELETE']);

$routes->connect('/frases/prompt/{promptId}', [
    'controller' => 'FrasesSemelhantes',
    'action' => 'getByPrompt'
])->setPatterns(['promptId' => '\d+'])->setMethods(['GET']);

/**
 * ============================================================
 * FLASHCARD TAGS
 * ============================================================
 */
$routes->connect('/flashcard-tags/flashcard/{flashcardId}', [
    'controller' => 'FlashcardTags',
    'action' => 'getByFlashcard'
])->setPatterns(['flashcardId' => '\d+'])->setMethods(['GET']);

$routes->connect('/flashcard-tags', [
    'controller' => 'FlashcardTags',
    'action' => 'add'
])->setMethods(['POST']);

$routes->connect('/flashcard-tags', [
    'controller' => 'FlashcardTags',
    'action' => 'remove'
])->setMethods(['DELETE']);

/**
 * ============================================================
 * FALLBACK
 * ============================================================
 */
$routes->connect('/*', [
    'controller' => 'Users',
    'action' => 'notFound'
]);
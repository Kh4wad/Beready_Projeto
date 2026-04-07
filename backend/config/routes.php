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

// ============================================
// USERS ROUTES
// ============================================

// Rota padrão com /view/
$routes->connect('/users/view/{id}', ['controller' => 'Users', 'action' => 'view'])
    ->setPatterns(['id' => '\d+'])
    ->setMethods(['GET']);

// Rota alternativa sem /view/ (frontend usa)
$routes->connect('/users/{id}', ['controller' => 'Users', 'action' => 'view'])
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

$routes->connect('/flashcards', ['controller' => 'Flashcards', 'action' => 'index'])->setMethods(['GET']);
$routes->connect('/flashcards', ['controller' => 'Flashcards', 'action' => 'add'])->setMethods(['POST']);

// Rota alternativa sem /view/ (frontend usa)
$routes->connect('/flashcards/{id}', ['controller' => 'Flashcards', 'action' => 'view'])
    ->setPatterns(['id' => '\d+'])
    ->setMethods(['GET']);

$routes->connect('/flashcards/view/{id}', ['controller' => 'Flashcards', 'action' => 'view'])
    ->setPatterns(['id' => '\d+'])
    ->setMethods(['GET']);

// Rota alternativa sem /edit/ (frontend usa)
$routes->connect('/flashcards/{id}', ['controller' => 'Flashcards', 'action' => 'edit'])
    ->setPatterns(['id' => '\d+'])
    ->setMethods(['PUT']);

$routes->connect('/flashcards/edit/{id}', ['controller' => 'Flashcards', 'action' => 'edit'])
    ->setPatterns(['id' => '\d+'])
    ->setMethods(['PUT']);

// Rota alternativa sem /delete/ (frontend usa)
$routes->connect('/flashcards/{id}', ['controller' => 'Flashcards', 'action' => 'delete'])
    ->setPatterns(['id' => '\d+'])
    ->setMethods(['DELETE']);

$routes->connect('/flashcards/delete/{id}', ['controller' => 'Flashcards', 'action' => 'delete'])
    ->setPatterns(['id' => '\d+'])
    ->setMethods(['DELETE']);

// ============================================
// QUIZES ROUTES
// ============================================

$routes->connect('/quizes', ['controller' => 'Quizes', 'action' => 'index'])->setMethods(['GET']);
$routes->connect('/quizes', ['controller' => 'Quizes', 'action' => 'add'])->setMethods(['POST']);

// Rota alternativa sem /view/ (frontend usa)
$routes->connect('/quizes/{id}', ['controller' => 'Quizes', 'action' => 'view'])
    ->setPatterns(['id' => '\d+'])
    ->setMethods(['GET']);

$routes->connect('/quizes/view/{id}', ['controller' => 'Quizes', 'action' => 'view'])
    ->setPatterns(['id' => '\d+'])
    ->setMethods(['GET']);

// Rota alternativa sem /edit/ (frontend usa)
$routes->connect('/quizes/{id}', ['controller' => 'Quizes', 'action' => 'edit'])
    ->setPatterns(['id' => '\d+'])
    ->setMethods(['PUT']);

$routes->connect('/quizes/edit/{id}', ['controller' => 'Quizes', 'action' => 'edit'])
    ->setPatterns(['id' => '\d+'])
    ->setMethods(['PUT']);

// Rota alternativa sem /delete/ (frontend usa)
$routes->connect('/quizes/{id}', ['controller' => 'Quizes', 'action' => 'delete'])
    ->setPatterns(['id' => '\d+'])
    ->setMethods(['DELETE']);

$routes->connect('/quizes/delete/{id}', ['controller' => 'Quizes', 'action' => 'delete'])
    ->setPatterns(['id' => '\d+'])
    ->setMethods(['DELETE']);

// ============================================
// PREFERENCIAS ROUTES
// ============================================

$routes->connect('/preferencias/usuario/{usuarioId}', ['controller' => 'Preferencias', 'action' => 'getByUsuario'])
    ->setPatterns(['usuarioId' => '\d+'])
    ->setMethods(['GET']);

$routes->connect('/preferencias', ['controller' => 'Preferencias', 'action' => 'save'])->setMethods(['POST']);

// ============================================
// TAGS ROUTES
// ============================================

$routes->connect('/tags', ['controller' => 'Tags', 'action' => 'index'])->setMethods(['GET']);
$routes->connect('/tags', ['controller' => 'Tags', 'action' => 'add'])->setMethods(['POST']);
$routes->connect('/tags/usuario/{usuarioId}', ['controller' => 'Tags', 'action' => 'getByUsuario'])
    ->setPatterns(['usuarioId' => '\d+'])
    ->setMethods(['GET']);
$routes->connect('/tags/view/{id}', ['controller' => 'Tags', 'action' => 'view'])
    ->setPatterns(['id' => '\d+'])
    ->setMethods(['GET']);
$routes->connect('/tags/edit/{id}', ['controller' => 'Tags', 'action' => 'edit'])
    ->setPatterns(['id' => '\d+'])
    ->setMethods(['PUT']);
$routes->connect('/tags/delete/{id}', ['controller' => 'Tags', 'action' => 'delete'])
    ->setPatterns(['id' => '\d+'])
    ->setMethods(['DELETE']);

// ============================================
// PROGRESSO USUARIO ROUTES
// ============================================

$routes->connect('/progresso/usuario/{usuarioId}', ['controller' => 'Progresso', 'action' => 'getByUsuario'])
    ->setPatterns(['usuarioId' => '\d+'])
    ->setMethods(['GET']);

$routes->connect('/progresso', ['controller' => 'Progresso', 'action' => 'save'])->setMethods(['POST']);

// ============================================
// PROMPTS ROUTES
// ============================================

$routes->connect('/prompts', ['controller' => 'Prompts', 'action' => 'index'])->setMethods(['GET']);
$routes->connect('/prompts/usuario/{usuarioId}', ['controller' => 'Prompts', 'action' => 'getByUsuario'])
    ->setPatterns(['usuarioId' => '\d+'])
    ->setMethods(['GET']);
$routes->connect('/prompts/view/{id}', ['controller' => 'Prompts', 'action' => 'view'])
    ->setPatterns(['id' => '\d+'])
    ->setMethods(['GET']);
$routes->connect('/prompts', ['controller' => 'Prompts', 'action' => 'add'])->setMethods(['POST']);
$routes->connect('/prompts/edit/{id}', ['controller' => 'Prompts', 'action' => 'edit'])
    ->setPatterns(['id' => '\d+'])
    ->setMethods(['PUT']);
$routes->connect('/prompts/delete/{id}', ['controller' => 'Prompts', 'action' => 'delete'])
    ->setPatterns(['id' => '\d+'])
    ->setMethods(['DELETE']);

// ============================================
// TRADUCOES ROUTES
// ============================================

$routes->connect('/traducoes/prompt/{promptId}', ['controller' => 'Traducoes', 'action' => 'getByPrompt'])
    ->setPatterns(['promptId' => '\d+'])
    ->setMethods(['GET']);
$routes->connect('/traducoes/view/{id}', ['controller' => 'Traducoes', 'action' => 'view'])
    ->setPatterns(['id' => '\d+'])
    ->setMethods(['GET']);
$routes->connect('/traducoes', ['controller' => 'Traducoes', 'action' => 'add'])->setMethods(['POST']);
$routes->connect('/traducoes/edit/{id}', ['controller' => 'Traducoes', 'action' => 'edit'])
    ->setPatterns(['id' => '\d+'])
    ->setMethods(['PUT']);
$routes->connect('/traducoes/delete/{id}', ['controller' => 'Traducoes', 'action' => 'delete'])
    ->setPatterns(['id' => '\d+'])
    ->setMethods(['DELETE']);

// ============================================
// IMAGENS GERADAS ROUTES
// ============================================

$routes->connect('/imagens/prompt/{promptId}', ['controller' => 'ImagensGeradas', 'action' => 'getByPrompt'])
    ->setPatterns(['promptId' => '\d+'])
    ->setMethods(['GET']);
$routes->connect('/imagens/view/{id}', ['controller' => 'ImagensGeradas', 'action' => 'view'])
    ->setPatterns(['id' => '\d+'])
    ->setMethods(['GET']);
$routes->connect('/imagens', ['controller' => 'ImagensGeradas', 'action' => 'add'])->setMethods(['POST']);
$routes->connect('/imagens/edit/{id}', ['controller' => 'ImagensGeradas', 'action' => 'edit'])
    ->setPatterns(['id' => '\d+'])
    ->setMethods(['PUT']);
$routes->connect('/imagens/delete/{id}', ['controller' => 'ImagensGeradas', 'action' => 'delete'])
    ->setPatterns(['id' => '\d+'])
    ->setMethods(['DELETE']);

// ============================================
// FRASES SEMELHANTES ROUTES
// ============================================

$routes->connect('/frases/prompt/{promptId}', ['controller' => 'FrasesSemelhantes', 'action' => 'getByPrompt'])
    ->setPatterns(['promptId' => '\d+'])
    ->setMethods(['GET']);
$routes->connect('/frases/view/{id}', ['controller' => 'FrasesSemelhantes', 'action' => 'view'])
    ->setPatterns(['id' => '\d+'])
    ->setMethods(['GET']);
$routes->connect('/frases', ['controller' => 'FrasesSemelhantes', 'action' => 'add'])->setMethods(['POST']);
$routes->connect('/frases/edit/{id}', ['controller' => 'FrasesSemelhantes', 'action' => 'edit'])
    ->setPatterns(['id' => '\d+'])
    ->setMethods(['PUT']);
$routes->connect('/frases/delete/{id}', ['controller' => 'FrasesSemelhantes', 'action' => 'delete'])
    ->setPatterns(['id' => '\d+'])
    ->setMethods(['DELETE']);

// ============================================
// FLASHCARD TAGS ROUTES
// ============================================

$routes->connect('/flashcard-tags/flashcard/{flashcardId}', ['controller' => 'FlashcardTags', 'action' => 'getByFlashcard'])
    ->setPatterns(['flashcardId' => '\d+'])
    ->setMethods(['GET']);
$routes->connect('/flashcard-tags', ['controller' => 'FlashcardTags', 'action' => 'add'])->setMethods(['POST']);
$routes->connect('/flashcard-tags', ['controller' => 'FlashcardTags', 'action' => 'remove'])->setMethods(['DELETE']);

// ============================================
// PROMPTS ROUTES COMPLETAS
// ============================================
$routes->connect('/prompts', ['controller' => 'Prompts', 'action' => 'index'])->setMethods(['GET']);
$routes->connect('/prompts/usuario/{usuarioId}', ['controller' => 'Prompts', 'action' => 'getByUsuario'])
    ->setPatterns(['usuarioId' => '\d+'])
    ->setMethods(['GET']);
$routes->connect('/prompts/view/{id}', ['controller' => 'Prompts', 'action' => 'view'])
    ->setPatterns(['id' => '\d+'])
    ->setMethods(['GET']);
$routes->connect('/prompts', ['controller' => 'Prompts', 'action' => 'add'])->setMethods(['POST']);
$routes->connect('/prompts/edit/{id}', ['controller' => 'Prompts', 'action' => 'edit'])
    ->setPatterns(['id' => '\d+'])
    ->setMethods(['PUT']);
$routes->connect('/prompts/delete/{id}', ['controller' => 'Prompts', 'action' => 'delete'])
    ->setPatterns(['id' => '\d+'])
    ->setMethods(['DELETE']);

// ============================================
// TRADUCOES ROUTES COMPLETAS
// ============================================
$routes->connect('/traducoes/prompt/{promptId}', ['controller' => 'Traducoes', 'action' => 'getByPrompt'])
    ->setPatterns(['promptId' => '\d+'])
    ->setMethods(['GET']);
$routes->connect('/traducoes/view/{id}', ['controller' => 'Traducoes', 'action' => 'view'])
    ->setPatterns(['id' => '\d+'])
    ->setMethods(['GET']);
$routes->connect('/traducoes', ['controller' => 'Traducoes', 'action' => 'add'])->setMethods(['POST']);
$routes->connect('/traducoes/edit/{id}', ['controller' => 'Traducoes', 'action' => 'edit'])
    ->setPatterns(['id' => '\d+'])
    ->setMethods(['PUT']);
$routes->connect('/traducoes/delete/{id}', ['controller' => 'Traducoes', 'action' => 'delete'])
    ->setPatterns(['id' => '\d+'])
    ->setMethods(['DELETE']);

// ============================================
// IMAGENS GERADAS ROUTES COMPLETAS
// ============================================
$routes->connect('/imagens/prompt/{promptId}', ['controller' => 'ImagensGeradas', 'action' => 'getByPrompt'])
    ->setPatterns(['promptId' => '\d+'])
    ->setMethods(['GET']);
$routes->connect('/imagens/view/{id}', ['controller' => 'ImagensGeradas', 'action' => 'view'])
    ->setPatterns(['id' => '\d+'])
    ->setMethods(['GET']);
$routes->connect('/imagens', ['controller' => 'ImagensGeradas', 'action' => 'add'])->setMethods(['POST']);
$routes->connect('/imagens/edit/{id}', ['controller' => 'ImagensGeradas', 'action' => 'edit'])
    ->setPatterns(['id' => '\d+'])
    ->setMethods(['PUT']);
$routes->connect('/imagens/delete/{id}', ['controller' => 'ImagensGeradas', 'action' => 'delete'])
    ->setPatterns(['id' => '\d+'])
    ->setMethods(['DELETE']);

// ============================================
// FRASES SEMELHANTES ROUTES COMPLETAS
// ============================================
$routes->connect('/frases/prompt/{promptId}', ['controller' => 'FrasesSemelhantes', 'action' => 'getByPrompt'])
    ->setPatterns(['promptId' => '\d+'])
    ->setMethods(['GET']);
$routes->connect('/frases/view/{id}', ['controller' => 'FrasesSemelhantes', 'action' => 'view'])
    ->setPatterns(['id' => '\d+'])
    ->setMethods(['GET']);
$routes->connect('/frases', ['controller' => 'FrasesSemelhantes', 'action' => 'add'])->setMethods(['POST']);
$routes->connect('/frases/edit/{id}', ['controller' => 'FrasesSemelhantes', 'action' => 'edit'])
    ->setPatterns(['id' => '\d+'])
    ->setMethods(['PUT']);
$routes->connect('/frases/delete/{id}', ['controller' => 'FrasesSemelhantes', 'action' => 'delete'])
    ->setPatterns(['id' => '\d+'])
    ->setMethods(['DELETE']);

// ============================================
// FLASHCARD TAGS ROUTES COMPLETAS
// ============================================
$routes->connect('/flashcard-tags/flashcard/{flashcardId}', ['controller' => 'FlashcardTags', 'action' => 'getByFlashcard'])
    ->setPatterns(['flashcardId' => '\d+'])
    ->setMethods(['GET']);
$routes->connect('/flashcard-tags', ['controller' => 'FlashcardTags', 'action' => 'add'])->setMethods(['POST']);
$routes->connect('/flashcard-tags', ['controller' => 'FlashcardTags', 'action' => 'remove'])->setMethods(['DELETE']);

// Fallback
$routes->connect('/*', ['controller' => 'Users', 'action' => 'notFound']);
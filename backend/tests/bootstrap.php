<?php

/**
 * Test runner bootstrap.
 *
 * Configura o ambiente de testes com SQLite em memória
 * e cria todas as tabelas necessárias para os testes.
 */

declare(strict_types=1);

use Cake\Chronos\Chronos;
use Cake\Core\Configure;
use Cake\Database\Connection;
use Cake\Database\Driver\Sqlite;
use Cake\Datasource\ConnectionManager;
use Cake\TestSuite\ConnectionHelper;
use Migrations\TestSuite\Migrator;

require dirname(__DIR__) . '/vendor/autoload.php';
require dirname(__DIR__) . '/config/bootstrap.php';

$httpHost = getenv('HTTP_HOST');

if ((null === $httpHost || '' === $httpHost) && !Configure::read('App.fullBaseUrl')) {
    Configure::write('App.fullBaseUrl', getenv('EMAIL_HOST'));
}

// ============================================
// FORÇA CONFIGURAÇÃO DO BANCO DE TESTES
// ============================================

if (ConnectionManager::getConfig('test')) {
    ConnectionManager::drop('test');
}

ConnectionManager::setConfig('test', [
    'className' => Connection::class,
    'driver' => Sqlite::class,
    'database' => ':memory:',
    'encoding' => 'utf8',
    'cacheMetadata' => true,
    'quoteIdentifiers' => false,
    'log' => false,
]);

try {
    $connection = ConnectionManager::get('test');
    // DESABILITA TOTALMENTE AS FK
    $connection->execute('PRAGMA foreign_keys = OFF');
    $connection->execute('PRAGMA defer_foreign_keys = ON');
    error_log("✅ Testes usando SQLite em memória - FK desabilitadas!");
} catch (\Exception $e) {
    error_log("⚠️ Erro ao configurar SQLite: " . $e->getMessage());
}

// ============================================
// CONFIGURAÇÃO DO DEBUGKIT
// ============================================
if (!ConnectionManager::getConfig('test_debug_kit')) {
    ConnectionManager::setConfig('test_debug_kit', [
        'className' => Connection::class,
        'driver' => Sqlite::class,
        'database' => TMP . 'debug_kit.sqlite',
        'encoding' => 'utf8',
        'quoteIdentifiers' => false,
    ]);
}

ConnectionManager::alias('test_debug_kit', 'debug_kit');

Chronos::setTestNow(Chronos::now());
session_id('cli');

ConnectionHelper::addTestAliases();

// ============================================
// CRIA TODAS AS TABELAS (SEM FK)
// ============================================
try {
    $connection = ConnectionManager::get('test');

    // users
    $connection->execute("
        CREATE TABLE IF NOT EXISTS users (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            uuid VARCHAR(36) DEFAULT NULL,
            nome VARCHAR(255) NOT NULL,
            email VARCHAR(255) NOT NULL UNIQUE,
            senha_hash VARCHAR(255) NOT NULL,
            telefone VARCHAR(20) DEFAULT NULL,
            nivel_ingles VARCHAR(50) DEFAULT NULL,
            idioma_preferido VARCHAR(10) DEFAULT 'pt-BR',
            status VARCHAR(20) DEFAULT 'ativo',
            reset_token VARCHAR(255) DEFAULT NULL,
            reset_token_expires DATETIME DEFAULT NULL,
            criado_em DATETIME NOT NULL,
            atualizado_em DATETIME NOT NULL
        )
    ");

    // flashcards
    $connection->execute("
        CREATE TABLE IF NOT EXISTS flashcards (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            uuid VARCHAR(36) DEFAULT NULL,
            user_id INTEGER NOT NULL,
            frase_original TEXT NOT NULL,
            frase_traduzida TEXT NOT NULL,
            contexto TEXT DEFAULT NULL,
            nivel_dificuldade VARCHAR(20) DEFAULT 'medio',
            tags VARCHAR(255) DEFAULT NULL,
            vezes_revisada INTEGER DEFAULT 0,
            ultima_revisao DATETIME DEFAULT NULL,
            proxima_revisao DATETIME DEFAULT NULL,
            criado_em DATETIME NOT NULL,
            atualizado_em DATETIME NOT NULL
        )
    ");

    // prompts
    $connection->execute("
        CREATE TABLE IF NOT EXISTS prompts (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            usuario_id INTEGER NOT NULL,
            texto_original TEXT NOT NULL,
            idioma_original VARCHAR(10) NOT NULL,
            contexto VARCHAR(50) DEFAULT NULL,
            midia_origem_id INTEGER DEFAULT NULL,
            sessao_id VARCHAR(255) DEFAULT NULL,
            uuid VARCHAR(36) DEFAULT NULL,
            criado_em DATETIME NOT NULL
        )
    ");

    // traducoes
    $connection->execute("
        CREATE TABLE IF NOT EXISTS traducoes (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            prompt_id INTEGER NOT NULL,
            texto_traduzido TEXT NOT NULL,
            idioma_destino VARCHAR(10) NOT NULL,
            pontuacao_confianca DECIMAL(5,2) DEFAULT NULL,
            servico_traducao VARCHAR(50) DEFAULT NULL,
            traducoes_alternativas TEXT DEFAULT NULL,
            criado_em DATETIME NOT NULL
        )
    ");

    // imagens_geradas
    $connection->execute("
        CREATE TABLE IF NOT EXISTS imagens_geradas (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            prompt_id INTEGER NOT NULL,
            traducao_id INTEGER DEFAULT NULL,
            url_imagem TEXT NOT NULL,
            prompt_imagem TEXT NOT NULL,
            servico_geracao VARCHAR(50) NOT NULL,
            qualidade_imagem VARCHAR(20) DEFAULT 'media',
            tamanho_arquivo INTEGER DEFAULT NULL,
            dimensoes VARCHAR(20) DEFAULT NULL,
            criado_em DATETIME NOT NULL
        )
    ");

    // tags
    $connection->execute("
        CREATE TABLE IF NOT EXISTS tags (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            nome VARCHAR(100) NOT NULL UNIQUE,
            criado_em DATETIME NOT NULL,
            atualizado_em DATETIME NOT NULL
        )
    ");

    // flashcard_tags
    $connection->execute("
        CREATE TABLE IF NOT EXISTS flashcard_tags (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            flashcard_id INTEGER NOT NULL,
            tag_id INTEGER NOT NULL,
            criado_em DATETIME NOT NULL
        )
    ");

    // quizes
    $connection->execute("
        CREATE TABLE IF NOT EXISTS quizes (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            user_id INTEGER NOT NULL,
            titulo VARCHAR(255) NOT NULL,
            descricao TEXT DEFAULT NULL,
            nivel_dificuldade VARCHAR(20) DEFAULT 'medio',
            pontuacao_maxima INTEGER DEFAULT 0,
            criado_em DATETIME NOT NULL,
            atualizado_em DATETIME NOT NULL
        )
    ");

    // frases_semelhantes
    $connection->execute("
        CREATE TABLE IF NOT EXISTS frases_semelhantes (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            prompt_id INTEGER NOT NULL,
            frase_semelhante TEXT NOT NULL,
            idioma VARCHAR(10) NOT NULL,
            pontuacao_similaridade DECIMAL(5,2) DEFAULT NULL,
            criado_em DATETIME NOT NULL
        )
    ");

    // preferencias_usuario
    $connection->execute("
        CREATE TABLE IF NOT EXISTS preferencias_usuario (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            user_id INTEGER NOT NULL UNIQUE,
            tema VARCHAR(50) DEFAULT 'light',
            notificacoes BOOLEAN DEFAULT 1,
            idioma_preferido VARCHAR(10) DEFAULT 'pt-BR',
            criado_em DATETIME NOT NULL,
            atualizado_em DATETIME NOT NULL
        )
    ");

    // progresso_usuario
    $connection->execute("
        CREATE TABLE IF NOT EXISTS progresso_usuario (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            user_id INTEGER NOT NULL,
            quiz_id INTEGER NOT NULL,
            pontuacao INTEGER DEFAULT 0,
            respostas_corretas INTEGER DEFAULT 0,
            respostas_erradas INTEGER DEFAULT 0,
            tempo_gasto INTEGER DEFAULT 0,
            concluido BOOLEAN DEFAULT 0,
            criado_em DATETIME NOT NULL,
            atualizado_em DATETIME NOT NULL
        )
    ");

    // respostas_usuario
    $connection->execute("
        CREATE TABLE IF NOT EXISTS respostas_usuario (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            user_id INTEGER NOT NULL,
            pergunta_id INTEGER NOT NULL,
            resposta TEXT NOT NULL,
            correta BOOLEAN DEFAULT 0,
            criado_em DATETIME NOT NULL
        )
    ");

    // Tabela vocabulario
    $connection->execute("
        CREATE TABLE IF NOT EXISTS vocabulario (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            user_id INTEGER NOT NULL,
            palavra VARCHAR(255) NOT NULL,
            traducao VARCHAR(255) NOT NULL,
            nivel VARCHAR(50) DEFAULT 'iniciante',
            criado_em DATETIME NOT NULL,
            atualizado_em DATETIME NOT NULL
        )
    ");

    error_log("✅ Todas as tabelas criadas sem restrições FK!");
} catch (Exception $e) {
    error_log("❌ Erro ao criar tabelas: " . $e->getMessage());
}

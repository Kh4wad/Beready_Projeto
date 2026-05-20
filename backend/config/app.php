<?php

use Cake\Cache\Engine\FileEngine;
use Cake\Database\Connection;
use Cake\Database\Driver\Postgres;
use Cake\Log\Engine\FileLog;

return [
    'debug' => true,

    'App' => [
        'namespace' => 'App',
        'encoding' => 'UTF-8',
        'defaultLocale' => 'pt_BR',
        'defaultTimezone' => 'America/Sao_Paulo',
        'base' => false,
        'dir' => 'src',
        'webroot' => 'webroot',
        'wwwRoot' => WWW_ROOT,
        'fullBaseUrl' => 'http://localhost:5173',
        'imageBaseUrl' => 'img/',
        'cssBaseUrl' => 'css/',
        'jsBaseUrl' => 'js/',
        'paths' => [
            'plugins' => [ROOT . DS . 'plugins' . DS],
            'templates' => [dirname(__DIR__) . DS . 'templates' . DS],
            'locales' => [RESOURCES . 'locales' . DS],
        ],
    ],

    'Security' => [
        'salt' => 'd7a8fbb307d7809469ca9abcb0082e4f8d5651e46d3cdb762d02d0bf37c9e592',
    ],

    // CONFIGURAÇÃO JWT - ADICIONADA
    'Jwt' => [
        'secret' => 'd7a8fbb307d7809469ca9abcb0082e4f8d5651e46d3cdb762d02d0bf37c9e592',
        'algorithm' => 'HS256',
        'expires' => 3600,
        'refresh_expires' => 604800,
    ],

    'Datasources' => [
        'default' => [
            'className' => Connection::class,
            'driver' => Postgres::class,
            'host' => 'aws-1-sa-east-1.pooler.supabase.com',
            'port' => 6543,
            'username' => 'postgres.bwppzgxlcqxfuzdehgyb',
            'password' => 'B3r3@dy#Sup4_9Xq!2026',
            'database' => 'postgres',
            'encoding' => 'utf8',
            'timezone' => 'UTC',
            'cacheMetadata' => true,
            'quoteIdentifiers' => false,
            'log' => false,
        ],
    ],

    'Cache' => [
        'default' => [
            'className' => FileEngine::class,
            'path' => CACHE,
        ],
        '_cake_core_' => [
            'className' => 'Array',
            'prefix' => 'myapp_cake_core_',
            'serialize' => true,
            'duration' => '+1 years',
        ],
        '_cake_model_' => [
            'className' => 'Array',
            'prefix' => 'myapp_cake_model_',
            'serialize' => true,
            'duration' => '+1 years',
        ],
    ],

    'Error' => [
        'errorLevel' => E_ALL,
        'log' => true,
        'trace' => true,
    ],

    'Log' => [
        'debug' => [
            'className' => FileLog::class,
            'path' => LOGS,
            'file' => 'debug',
            'levels' => ['notice', 'info', 'debug'],
        ],
        'error' => [
            'className' => FileLog::class,
            'path' => LOGS,
            'file' => 'error',
            'levels' => ['warning', 'error', 'critical', 'alert', 'emergency'],
        ],
    ],

    'EmailTransport' => [
        'default' => [
            'className' => 'Cake\Mailer\Transport\MailTransport',
            'host' => 'localhost',
            'port' => 25,
            'timeout' => 30,
            'client' => null,
            'tls' => false,
            'url' => env('EMAIL_TRANSPORT_DEFAULT_URL', null),
        ],
    ],

    'Email' => [
        'default' => [
            'transport' => 'default',
            'from' => ['noreply@beready.com' => 'BeReady'],
            'charset' => 'utf-8',
            'headerCharset' => 'utf-8',
        ],
    ],

    'Session' => [
        'defaults' => 'php',
    ],
];
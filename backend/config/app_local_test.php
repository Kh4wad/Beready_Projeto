<?php
/**
 * Configuração para ambiente de TESTES
 * 
 * Este arquivo é carregado APENAS durante os testes
 * Usa SQLite em memória - banco é criado e destruído automaticamente!
 * NÃO afeta o banco de desenvolvimento!
 */

use Cake\Database\Connection;
use Cake\Database\Driver\Sqlite;

return [
    'Datasources' => [
        'test' => [
            'className' => Connection::class,
            'driver' => Sqlite::class,
            'database' => ':memory:',
            'encoding' => 'utf8',
            'cacheMetadata' => true,
            'quoteIdentifiers' => false,
            'log' => false,
        ],
    ],
];
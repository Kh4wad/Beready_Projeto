<?php

use function Cake\Core\env;

return [
    'debug' => filter_var(env('DEBUG', true), FILTER_VALIDATE_BOOLEAN),

    'Security' => [
        'salt' => env('SECURITY_SALT', '__SALT__'),
    ],

    'Datasources' => [
        'default' => [
            'host' => 'localhost',
            //'port' => '3306',
            'username' => 'root',
            'password' => '',
            'database' => 'Beready',
            //'schema' => 'myapp',
            'url' => env('DATABASE_URL', null)
        ],

        'test' => [
            'host' => 'localhost',
            //'port' => '3306',
            'username' => 'root',
            'password' => '',
            'database' => 'test_Beready',
            //'schema' => 'myapp',
            'url' => env('DATABASE_TEST_URL', 'sqlite://127.0.0.1/tmp/tests.sqlite')
        ]
    ],

    'EmailTransport' => [
        'default' => [
            'host' => 'localhost',
            'port' => 25,
            'username' => null,
            'password' => null,
            'client' => null,
            'url' => env('EMAIL_TRANSPORT_DEFAULT_URL', null)
        ]
    ],
];

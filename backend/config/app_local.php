<?php

return [
    'EmailTransport' => [
        'default' => [
            'className' => 'Smtp',
            'host' => env('EMAIL_HOST'),
            'port' => env('EMAIL_PORT'),
            'username' => env('EMAIL_USERNAME'),
            'password' => env('EMAIL_PASSWORD'),
            'tls' => (bool)env('EMAIL_TLS'),
            'timeout' => 30,
        ],
    ],

    'Email' => [
        'default' => [
            'transport' => 'default',
            'from' => env('EMAIL_FROM'),
            'charset' => env('APP_ENCODING'),
            'headerCharset' => env('APP_ENCODING'),
        ],
    ],
    
    'Datasources' => [
        'default' => [
            'className' => Connection::class,
            'driver' => Postgres::class,
            'url' => env('DATABASE_URL'),
        ],

        'test' => [
            'className' => Connection::class,
            'driver' => Postgres::class,
            'url' => env('DATABASE_URL'),
            'database' => 'beready_test',
            'schema' => 'public',
            'cacheMetadata' => true,
        ],
    ],
];

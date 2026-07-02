<?php
return [
    'EmailTransport' => [
        'default' => [
            'className' => 'Debug',
        ],
    ],

    'Email' => [
        'default' => [
            'transport' => 'default',
            'from'    => env('EMAIL_FROM'),
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
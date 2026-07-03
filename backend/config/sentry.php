<?php

use function Cake\Core\env;

$dsn = env('SENTRY_DSN');

if (!empty($dsn)) {
    \Sentry\init([
        'dsn' => $dsn,
        'environment' => env('APP_ENV', 'development'),
        'traces_sample_rate' => 1.0,
        'send_default_pii' => false,
        'release' => '1.0.0',
        'http_ssl_verify_peer' => false,
        'before_send' => function ($event) {
            return $event;
        },
    ]);
    
}
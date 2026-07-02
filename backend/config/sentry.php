<?php

use function Cake\Core\env;

\Sentry\init([
    'dsn' => getenv('SENTRY_DSN'),

    'environment' => env('APP_ENV', 'development'),

    'traces_sample_rate' => 1.0,

    'send_default_pii' => false,

]);
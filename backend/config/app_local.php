<?php
return [
    'EmailTransport' => [
        'default' => [
            'className' => 'Smtp',
            'host' => 'smtp.gmail.com',
            'port' => 587,
            'timeout' => 30,
            'username' => 'seuemail@gmail.com',
            'password' => 'suasenha',
            'client' => null,
            'tls' => true,
            'url' => env('EMAIL_URL', null),
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
];
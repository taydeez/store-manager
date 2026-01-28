<?php

return [

    'paths' => [
        'api/*',
        'login',
    ],

    'allowed_methods' => ['*'],

    'allowed_origins' => [
        'http://localhost:3000',
        'https://store-manager-fe-m9rm-mpfwtqqv5-demis-projects-21e0bf22.vercel.app',
        'https://store-manager-fe-m9rm-ax7j9ku8o-demis-projects-21e0bf22.vercel.app',
        'https://books.lwmportal.com',
    ],

    'allowed_headers' => ['*'],

    'exposed_headers' => [],

    'max_age' => 0,

    'supports_credentials' => false,
];

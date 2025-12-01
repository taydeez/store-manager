<?php

return [

    'paths' => ['api/*', 'login'], // remove csrf-cookie

    'allowed_origins' => ['http://localhost:3000',
        'https://store-manager-fe-m9rm-mpfwtqqv5-demis-projects-21e0bf22.vercel.app',
        'https://store-manager-fe-m9rm-ax7j9ku8o-demis-projects-21e0bf22.vercel.app'],

    'supports_credentials' => false,
];

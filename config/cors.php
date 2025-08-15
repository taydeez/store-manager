<?php

return [

'paths' => ['api/*','login'], // remove csrf-cookie

'allowed_origins' => ['http://localhost:3000'],

'supports_credentials' => false,
];

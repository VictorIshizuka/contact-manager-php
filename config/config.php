<?php

return [

    'database' => [

        'driver' => 'sqlite',
        'database' => '../database/contact-manager-db.sqlite',
    ],
    'security' => [
        'first_key' => env('ENCRYPT_FIRST_KEY', base64_encode('first_key12345')),
        'second_key' => env('ENCRYPT_SECOND_KEY', base64_encode('second_key12345')),
    ],
    'date' => [
        'tz' => env('TZ', 'America/Sao_Paulo'),

    ],

];

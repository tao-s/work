<?php

return [

    'multi' => [
        'customer' => [
            'driver' => 'eloquent',
            'model' => 'App\Customer',
        ],
        'admin' => [
            'driver' => 'eloquent',
            'model' => 'App\Admin',
        ],
        'client' => [
            'driver' => 'eloquent',
            'model' => 'App\ClientRep',
        ]
    ],

    'password' => [
        'email' => 'emails.password',
        'table' => 'password_reset',
        'expire' => 60,
    ],

];

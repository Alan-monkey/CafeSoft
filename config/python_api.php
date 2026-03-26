<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Python API Configuration
    |--------------------------------------------------------------------------
    |
    | Configuración para la conexión con la API Python
    |
    */

    'base_url' => env('PYTHON_API_URL', 'http://localhost:9000'),
    
    'timeout' => env('PYTHON_API_TIMEOUT', 6),
    
    'endpoints' => [
        'productos' => [
            'list' => '/productos',
            'show' => '/productos/{id}',
            'store' => '/productos',
            'update' => '/productos/{id}',
            'delete' => '/productos/{id}',
        ],
    ],
];

<?php

return [

    /**
     * Default Strapi client name.
     */
    'default' => env('STRAPI_CLIENT', 'default'),

    /**
     * Strapi clients.
     */
    'clients' => [

        'default' => [
            'endpoint' => env('STRAPI_ENDPOINT'),
            'token' => env('STRAPI_TOKEN'),
        ],

    ],

];

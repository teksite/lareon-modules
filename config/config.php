<?php

return [
    'name' => 'Oauth',
    "types" => [
        'google' => [
            'secret_key'=>env('GOOGLE_SECRET_KEY'),
            'client_id'=>env('GOOGLE_GOOGLE_CLIENT_ID'),
        ],
        'linkedin' => [
            'secret_key'=>env('GOOGLE_SECRET_KEY'),
            'client_id'=>env('GOOGLE_GOOGLE_CLIENT_ID'),
        ],

        'github' => [
            'secret_key'=>env('GOOGLE_SECRET_KEY'),
            'client_id'=>env('GOOGLE_GOOGLE_CLIENT_ID'),
        ],
        'gitlab' => [
            'secret_key'=>env('GOOGLE_SECRET_KEY'),
            'client_id'=>env('GOOGLE_GOOGLE_CLIENT_ID'),
        ],
        'facebook' => [
            'secret_key'=>env('GOOGLE_SECRET_KEY'),
            'client_id'=>env('GOOGLE_GOOGLE_CLIENT_ID'),
        ],
        'twitter' => [
            'secret_key'=>env('GOOGLE_SECRET_KEY'),
            'client_id'=>env('GOOGLE_GOOGLE_CLIENT_ID'),
        ],
    ]
];

<?php

return [
    'payselection' => [
        'local'=>[
            'x_site_id'=>env('X_SITE_ID'),
            'secret_key'=>env('X_SECRET_KEY'),
            'public_key'=>env('X_PUBLIC_KEY'),
        ],
        'production'=>[
            'x_site_id'=>env('X_SITE_ID'),
            'secret_key'=>env('X_SECRET_KEY'),
            'public_key'=>env('X_PUBLIC_KEY'),
        ]
    ],
    'epay' => [
        'local'=>[
            'client_id' => env('CLIENT_ID'),
            'client_secret' => env('CLIENT_SECRET'),
            'terminal_id' => env('TERMINAL_ID'),
            'url'=> env('TEST_URL'),
            'url2' => env('TEST_URL2'),
            'js_lib_url'=> env('JS_LIB_URL_TEST'),
        ],
        'production'=>[
            'client_id' => env('CLIENT_ID'),
            'client_secret' => env('CLIENT_SECRET'),
            'terminal_id' => env('TERMINAL_ID'),
            'url'=> env('PROD_URL'),
            'url2' => env('PROD_URL2'),
            'js_lib_url'=> env('JS_LIB_URL_PROD')
        ]
    ],
    'stripe' => [
        'local'=>[
            'secret_key' => env('STRIPE_SK_TEST'),
            'public_key' => env('STRIPE_PK_TEST'),
            'monthly_price_id' => env('STRIPE_MONTHLY_PRICE_ID'),
            'annual_price_id' => env('STRIPE_ANNUAL_PRICE_ID'),
        ],
        'production'=>[
            'secret_key' => env('STRIPE_SK_PROD'),
            'public_key' => env('STRIPE_PK_PROD'),
            'monthly_price_id' => env('STRIPE_MONTHLY_PRICE_ID'),
            'annual_price_id' => env('STRIPE_ANNUAL_PRICE_ID'),
        ]
    ]
];

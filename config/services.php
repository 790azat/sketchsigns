<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Resend, Postmark, AWS, and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'postmark' => [
        'key' => env('POSTMARK_API_KEY'),
    ],

    'resend' => [
        'key' => env('RESEND_API_KEY'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'slack' => [
        'notifications' => [
            'bot_user_oauth_token' => env('SLACK_BOT_USER_OAUTH_TOKEN'),
            'channel' => env('SLACK_BOT_USER_DEFAULT_CHANNEL'),
        ],
    ],

    'woo' => [
        // Public WooCommerce Store API of the old WordPress site, used by the catalog importer.
        'url' => env('WOO_STORE_API_URL', 'https://sketchsigns.com/wp-json/wc/store/v1'),
    ],

    'blob' => [
        'token' => env('BLOB_READ_WRITE_TOKEN'),
        'api_url' => env('VERCEL_BLOB_API_URL', 'https://vercel.com/api/blob'),
        'serve_origin' => (bool) env('BLOB_SERVE_ORIGIN', false),
    ],

    // Protects the /admin/sync endpoints that run migrations and the catalog import on Vercel.
    'admin_token' => env('ADMIN_TOKEN'),

];

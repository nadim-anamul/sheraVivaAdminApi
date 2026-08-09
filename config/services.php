<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
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

    'gemini' => [
        'key' => env('GEMINI_API_KEY'),
        'model' => env('GEMINI_MODEL', 'gemini-2.5-flash'),
        'model_conversation' => env('GEMINI_MODEL_CONVERSATION', 'gemini-3.6-flash'),
        'model_evaluation' => env('GEMINI_MODEL_EVALUATION', 'gemini-3.6-pro'),
    ],

    'admin' => [
        'email' => env('ADMIN_EMAIL', 'admin@seraviva.com'),
        'password' => env('ADMIN_PASSWORD', 'password'),
    ],

    'shera_viva' => [
        'api_key' => env('SHERA_VIVA_API_KEY', 'sv_secret_key_123456'),
    ],

];

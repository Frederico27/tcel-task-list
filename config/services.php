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
        'token' => env('POSTMARK_TOKEN'),
    ],

    'resend' => [
        'key' => env('RESEND_KEY'),
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

    'e-portal' => [
        'url_portal_session' => env('E_PORTAL_SESSION'),
        'url_portal' => env('E_PORTAL_BASE'),
        'bearer_token' => env('BEARER_TOKEN'),
        'username' => env('USERNAME_SSO_TCEL'),
        'password' => env('PASSWORD_SSO_TCEL'),
        'tree_menu_id' => env('TREEMENUID'),
        'key_cookies' => env('KEY_COOKIES_SSO_TCEL', '__secure_sso_tcel'),
        'admin_nik' => env('ADMIN_NIK')
    ]

];

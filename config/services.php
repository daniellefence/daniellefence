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

    'google' => [
        'places' => [
            'api_key' => env('GOOGLE_PLACES_API_KEY'),
            'place_id' => env('GOOGLE_PLACES_PLACE_ID'),
        ],
    ],

    'openai' => [
        'api_key' => env('OPENAI_API_KEY'),
    ],

    'zapier' => [
        'webhook_url' => env('ZAPIER_WEBHOOK_URL', 'https://grillbert.zapier.app'),
    ],

    'remote_users' => [
        'api_url' => env('REMOTE_USERS_API_URL', 'https://it.daniellehub.com'),
        'auth_key' => env('REMOTE_USERS_AUTH_KEY', 'uD3rA9XqLp6YzbNf'),
        'shared_key' => env('REMOTE_USERS_SHARED_KEY', 'cJ7nEpn8S3eCzXpiBqvNvmLd7ntrz8RZSGbtL9iQgIM='),
    ],

    'youtube' => [
        'api_key' => env('YOUTUBE_API_KEY', ''),
        'channel_id' => env('YOUTUBE_CHANNEL_ID', ''),
        // Your channel handle: @daniellefenceoutdoorliving8500
        // Channel URL: https://www.youtube.com/@daniellefenceoutdoorliving8500
    ],

];

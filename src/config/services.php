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

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'resend' => [
        'key' => env('RESEND_KEY'),
    ],

    'slack' => [
        'notifications' => [
            'bot_user_oauth_token' => env('SLACK_BOT_USER_OAUTH_TOKEN'),
            'channel' => env('SLACK_BOT_USER_DEFAULT_CHANNEL'),
        ],
    ],

    'tmdb' => [
        'api_key' => env('TMDB_API_KEY'),
        'endpoint_movies' => env('TMDB_ENDPOINT_MOVIES'),
        'endpoint_one_movie' => env('TMDB_ENDPOINT_ONE_MOVIE'),
        'endpoint_favorite_movies' => env('TMDB_ENDPOINT_FAVORITE_MOVIES'),
        'endpoint_add_favorite_movies' => env('TMDB_ENDPOINT_ADD_FAVORITE_MOVIES'),
        'endpoint_genres' => env('TMDB_ENDPOINT_GENRES'),
        'endpoint_session_id' => env('TMDB_SESSION_ID'),
    ],

];

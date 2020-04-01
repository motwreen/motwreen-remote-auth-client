<?php
return [
    /* Remote Server Config */
    /*
    |--------------------------------------------------------------------------
    | Remote Server url
    |--------------------------------------------------------------------------
    |
    | This value is the url of your auth server. This value is used to set base url
    | for the remote server apis
    |
    */

    'auth_server_url' => env('AUTH_SERVER_URL', 'http://accounts.example.com'),

    /*
    |--------------------------------------------------------------------------
    | Auth Server Apis Prefix
    |--------------------------------------------------------------------------
    |
    | This value is used to set prefix before api endpoints on remote server
    |
    */

    'auth_server_api_prefix' => 'api',

    /*
    |--------------------------------------------------------------------------
    | OAuth Server Token Path
    |--------------------------------------------------------------------------
    |
    | *Un-prefixed* value of oauth token endpoint on remote server
    | this would results : http://example.com/oauth/token
    |
    */
    'auth_server_oauth_path' => 'oauth',

    /*
    |--------------------------------------------------------------------------
    | Get User data endpoint
    |--------------------------------------------------------------------------
    |
    | *prefixed* value of logged in user data returner ex: me
    | this would results : http://example.com/{api_prefix}/me
    |
    */

    'auth_server_user_data_path' => 'me',

    /*
    |--------------------------------------------------------------------------
    | OAuth2 Client Config
    |--------------------------------------------------------------------------
    |
    | Your OAuth2 app configurations
    |
    */
    'auth_server_client_id' => env('AUTH_SERVER_CLIENT_ID'),

    'auth_server_client_secret' => env('AUTH_SERVER_CLIENT_SECRET'),

    'auth_server_callback_url' => env('AUTH_SERVER_CALLBACK_URL'),

    'auth_server_scopes' => [

        'user.retrieve',

        'user.update',

    ],


    /* Local Server Config */
    /*
    |--------------------------------------------------------------------------
    | Routes
    |--------------------------------------------------------------------------
    |
    | Define routes URIs
    |
    */

    'routes' => [

        'callback' => 'auth/callback',

        'redirect' => 'auth/redirect',
    ],

    /*
    |--------------------------------------------------------------------------
    | Guard name
    |--------------------------------------------------------------------------
    |
    | Set the name of runtime created guard
    |
    */

    'guard' => 'token',

    /*
    |--------------------------------------------------------------------------
    | Token holder key name
    |--------------------------------------------------------------------------
    |
    | Set the key name of token holder and guard driver name.
    |
    */
    'token_holder' => 'access_token',

    /*
    |--------------------------------------------------------------------------
    | Http Client Config
    |--------------------------------------------------------------------------
    |
    | Config for http client ( GuzzleHttp ). These config will passed as you define
    | WARNING : ny wrong options here would crash the system
    |
    */
    'http' => [
        /*
        |--------------------------------------------------------------------------
        | SSL force verify
        |--------------------------------------------------------------------------
        |
        | Verify origin has a valid ssl
        |
        */
        'verify' => false,

        'allow_redirects' => [
            'max'             => 5,
            'strict'          => true,
            'referer'         => false,
            'protocols'       => ['http', 'https'],
            'track_redirects' => true,
        ],

    ]

];

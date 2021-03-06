<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Stripe, Mailgun, Mandrill, and others. This file provides a sane
    | default location for this type of information, allowing packages
    | to have a conventional place to find your various credentials.
    |
    */

    'mailgun' => [
        'domain' => '',
        'secret' => '',
    ],
    'mandrill' => [
        'secret' => '',
    ],
    'ses' => [
        'key'    => '',
        'secret' => '',
        'region' => 'us-east-1',
    ],
    'stripe' => [
        'model'  => 'App\User',
        'secret' => '',
    ],
    'facebook' => [
        'client_id'     => getenv('FACEBOOK_ID'),
        'client_secret' => getenv('FACEBOOK_SECRET'),
        'redirect'      => 'http://furnace.autopergamene.eu/auth/socialize/facebook/callback',
    ],
    'twitter' => [
        'client_id'     => getenv('TWITTER_ID'),
        'client_secret' => getenv('TWITTER_SECRET'),
        'redirect'      => 'http://furnace.autopergamene.eu/auth/socialize/twitter/callback',
    ],
    'lastfm' => [
        'client_id'     => getenv('LASTFM_ID'),
        'client_secret' => getenv('LASTFM_SECRET'),
    ],
];

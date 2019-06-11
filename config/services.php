<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Stripe, Mailgun, SparkPost and others. This file provides a sane
    | default location for this type of information, allowing packages
    | to have a conventional place to find your various credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
        'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
    ],

    'ses' => [
        'key' => env('SES_KEY'),
        'secret' => env('SES_SECRET'),
        'region' => env('SES_REGION', 'us-east-1'),
    ],

    'sparkpost' => [
        'secret' => env('SPARKPOST_SECRET'),
    ],

    'stripe' => [
        'model' => App\User::class,
        'key' => env('STRIPE_KEY'),
        'secret' => env('STRIPE_SECRET'),
        'webhook' => [
            'secret' => env('STRIPE_WEBHOOK_SECRET'),
            'tolerance' => env('STRIPE_WEBHOOK_TOLERANCE', 300),
        ],
    ],
	'twitter' => [
		'client_id' => 'wHw4amoIX2x6zAe9j4Y1nyZR8',
		'client_secret' => 'peMWrYhdSs8USXl54SjiNVjaue0ojTMSaI7EFJARhU6ZSzcdoM',
		'redirect' => 'http://social.watch/twitter/callback'
	],
	'facebook' => [
		'client_id' => '2766310426743947',
		'client_secret' => '0e42eb5a004e642378a5cc4254869969',
		'redirect' => 'https://social.watch/facebook/callback'
	]

];

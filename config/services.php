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
		'client_id' => 'xI09hsgQc6iqfdM3NYU1PKLEF',
		'client_secret' => 'qXjGUI2DAPWb5pWSfb6aLqPZu9dx3YzM2EROh26qU6ILCYSCda',
		'redirect' => 'https://twitter.nogetdigitalt.dk/twitter/callback'
	],
	'facebook' => [
		'client_id' => '2766310426743947',
		'client_secret' => '0a0c78c2071d97d0e7df73eef8c4badd',
		'redirect' => 'https://twitter.nogetdigitalt.dk/facebook/callback'
	]

];

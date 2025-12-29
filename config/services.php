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

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
        'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
        'scheme' => 'https',
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],
    'sms_gateway' => [
        'url' => env('SMS_GATEWAY_URL'),
        'api_key' => env('SMS_GATEWAY_API_KEY'),
        'sender_id' => env('SMS_GATEWAY_SENDER_ID'),
        'sender_name' => env('SMS_GATEWAY_SENDER_NAME'),
        'default_country_code' => env('SMS_GATEWAY_DEFAULT_COUNTRY_CODE', '+1'),
        'entity_id' => env('SMS_GATEWAY_ENTITY_ID'),
        'template_id' => env('SMS_GATEWAY_TEMPLATE_ID'),
        'route' => env('SMS_GATEWAY_ROUTE'),
        // 'flash_sms' => env('SMS_GATEWAY_FLASH_SMS', 0), // Optional, default is 0
    ],

];

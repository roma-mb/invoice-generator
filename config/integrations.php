<?php

declare(strict_types=1);

use App\Enumerators\Domain;
use App\Enumerators\Webmania;

return [
    Webmania::WEBMANIA->value => [
        Domain::API->value => env('WEBMANIA_API', ''),
        Domain::CREDENTIALS->value => [
            'X-Consumer-Key' => env('CONSUMER_KEY', ''),
            'X-Consumer-Secret' => env('CONSUMER_SECRET', ''),
            'X-Access-Token' => env('ACCESS_TOKEN', ''),
            'X-Access-Token-Secret' => env('ACCESS_TOKEN_SECRET', ''),
        ],
    ]
];

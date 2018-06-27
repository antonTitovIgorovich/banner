<?php

return [
    'driver' => env('SMS_DRIVER', 'sms'),

    'drivers' => [
        'sms' => [
            'api_id' => env('SMS_API_ID'),
            'url' => env('SMS_URL'),
        ],
    ],
];

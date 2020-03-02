<?php

return [
    'etsy' => [
        'client_id' => env('ETSY_CONSUMER_KEY'),
        'client_secret' => env('ETSY_CONSUMER_SECRET'),
        'redirect' => env('ETSY_REDIRECT_URI')
    ],
    'linkedin' => [
        'client_id' => env('GITHUB_CLIENT_ID'),
        'client_secret' => env('GITHUB_CLIENT_SECRET'),
        'redirect' => 'http://your-callback-url',
    ],
];

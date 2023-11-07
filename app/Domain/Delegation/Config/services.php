<?php
return [
    'worker' => [
        'id_length' => env('WORKER_ID_LENGTH', 32),
        'company' => env('COMPANY', 'X')
    ],
    'delegation' => [
        'currency' => env('DELEGATION_CURRENCY', 'PLN'),
        'hours' => env('DELEGATION_HOURS', 8),
        'bonus_rate' => env('DELEGATION_BONUS_RATE', 2),
        'bonus_days' => env('DELEGATION_BONUS_DAYS', 7),
    ]
];

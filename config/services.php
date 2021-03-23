<?php

use App\Service;

/**
 * Notes:
 * - URLs must be a direct link to the changelog
 */

return [
    'laravel' => [
        'name' => 'Laravel',
        'url' => 'https://raw.githubusercontent.com/laravel/laravel/' . Service::VERSION_EXPR .'/CHANGELOG.md',
        'versions' => [
            '5.4', '5.5', '5.6', '5.7', '5.8',
            '6.x', '7.x', '8.x',
        ]
    ],

    'react' => [
        'name' => 'React',
        'url' => 'https://raw.githubusercontent.com/facebook/react/' . Service::VERSION_EXPR . '/CHANGELOG.md',
        'versions' => [
            '0.4-stable', '0.5-stable', '0.8-stable', '0.9-stable',
            '0.10-stable', '0.11-stable', '0.12-stable', '0.13-stable', '0.14-stable',
            '15-stable',
            '16.8.3', '16.8.4', '16.8.5', '16.8.6',
            '17.0.1', '17.0.2',
        ]
    ],

    'laravel-horizon' => [
        'name' => 'Laravel Horizon',
        'url' => 'https://raw.githubusercontent.com/laravel/horizon/' . Service::VERSION_EXPR . '/CHANGELOG.md',
        'versions' => [
            '2.0',
            '3.0',
            '4.x',
            '5.x',
        ]
    ]
];

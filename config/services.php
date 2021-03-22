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
            '5.6',
            '5.7',
            '5.8',
        ]
    ],

    'react' => [
        'name' => 'React',
        'url' => 'https://raw.githubusercontent.com/facebook/react/' . Service::VERSION_EXPR . '-stable/CHANGELOG.md',
        'versions' => [
            '0.4',
            '0.5',
            '0.8',
        ]
    ]
];

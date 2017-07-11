<?php
declare(strict_types = 1);

$config = [
    'menu' => [
        'dashboard' => [
            'title' => __('dashboard.index.title'),
            'icon' => 'dashboard',
            'url' => [
                'plugin' => null,
                'controller' => 'Dashboard',
                'action' => 'index'
            ]
        ],
        'user' => [
            'title' => __('user.index.title'),
            'icon' => 'users',
            'url' => [
                'plugin' => null,
                'controller' => 'Users',
                'action' => 'index'
            ]
        ]
    ]
];

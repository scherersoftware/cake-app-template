<?php
$config = [
    'menu' => [
        'dashboard' => [
            'title' => __('dashboard.index.title'),
            'icon' => 'dashboard',
            'url' => [
                'plugin' => 'Admin',
                'controller' => 'Dashboard',
                'action' => 'index'
            ]
        ],
        'users' => [
            'title' => __('users.index.title'),
            'icon' => 'users',
            'url' => [
                'plugin' => 'Admin',
                'controller' => 'Users',
                'action' => 'index'
            ]
        ],
        'notifications' => [
            'title' => __('notifications.index.title'),
            'icon' => 'users',
            'url' => [
                'plugin' => 'Notifications',
                'controller' => 'NotificationContents',
                'action' => 'index'
            ]
        ]
    ]
];

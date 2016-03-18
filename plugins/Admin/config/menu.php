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
        ],
        'cms' => [
            'title' => __d('cms', 'cms.name'),
            'icon' => 'file-text-o',
            'children' => [
                'pages' => [
                    'title' => __d('cms', 'cms_pages.index.title'),
                    'icon' => 'file-text',
                    'url' => [
                        'plugin' => 'Cms',
                        'controller' => 'CmsPages',
                        'action' => 'index'
                    ],
                ]
            ]
        ],
        'wiki' => [
            'title' => __d('wiki', 'wiki_pages.index'),
            'icon' => 'file-text-o',
            'url' => [
                'plugin' => 'Scherersoftware/Wiki',
                'controller' => 'WikiPages',
                'action' => 'index'
            ],
        ],
    ]
];

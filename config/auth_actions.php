<?php
use App\Model\Entity\User;

$config = [
    'auth_settings' => [
        'camelizedControllerNames' => true
    ],
    'public_actions' => [
        'Home' => '*',
        'Admin.Login' => [
            'login',
            'logout',
            'forgotPassword',
            'restorePassword'
        ],
        'Api.Users' => [
            'authenticate'
        ],
        'Cms.CmsPages' => [
            'show'
        ]
    ],
    'auth_actions' => [
        'Admin.Dashboard' => [
            '*' => [User::ROLE_ADMIN]
        ],
        'Admin.Users' => [
            '*' => [User::ROLE_ADMIN]
        ],
        'Admin.Profile' => [
            '*' => [User::ROLE_ADMIN]
        ],
        'Admin.Login' => [
            '*' => [User::ROLE_ADMIN]
        ],
        'ModelHistory.ModelHistory' => [
            '*' => [User::ROLE_ADMIN]
        ],
        'Notifications.NotificationContents' => [
            '*' => [User::ROLE_ADMIN]
        ],
        'Attachments.Attachments' => [
            'preview' => '*',
            'download' => '*',
            '*' => [User::ROLE_ADMIN]
        ],
        'CkTools.Moxiemanager' => [
            '*' => [User::ROLE_ADMIN]
        ],
        'Cms.CmsPages' => [
            '*' => [User::ROLE_ADMIN]
        ],
        'Cms.CmsRows' => [
            '*' => [User::ROLE_ADMIN]
        ],
        'Cms.CmsBlocks' => [
            '*' => [User::ROLE_ADMIN]
        ],
        'Api.Users' => [
            'current' => [User::ROLE_ADMIN]
        ]
    ]
];

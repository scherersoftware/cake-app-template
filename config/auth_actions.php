<?php
use App\Model\Entity\User;

$config = [
    'auth_settings' => [
        'camelizedControllerNames' => true
    ],
    'public_actions' => [
        'Login' => [
            'login',
            'logout',
            'forgotPassword',
            'restorePassword'
        ],
        'Home' => '*',
        'Api/V1.Users' => [
            'authorize',
            'forgotPassword'
        ]
    ],
    'auth_actions' => [
        'Dashboard' => [
            '*' => [User::ROLE_ADMIN]
        ],
        'Users' => [
            '*' => [User::ROLE_ADMIN]
        ],
        'Profile' => [
            '*' => [User::ROLE_ADMIN]
        ],
        'Attachments.Attachments' => [
            'preview' => '*',
            'download' => '*',
            '*' => [User::ROLE_ADMIN]
        ],
        'Api/V1.Users' => [
            '*' => [User::ROLE_ADMIN]
        ],
        'ModelHistory.ModelHistory' => [
            '*' => [User::ROLE_ADMIN]
        ]
    ]
];

<?php
use App\Model\Entity\User;

$config = [
    'auth_settings' => [
        'camelizedControllerNames' => true
    ],
    'public_actions' => [
        'Home' => '*',
        'Login' => [
            'login',
        ],
        'Admin.Login' => [
            'login',
        ]
    ],
    'auth_actions' => [
        'Admin.Dashboard' => [
            '*' => [User::ROLE_ADMIN]
        ],
        'Admin.Profile' => [
            '*' => [User::ROLE_ADMIN]
        ],
        'Admin.Login' => [
            '*' => [User::ROLE_ADMIN]
        ],
    ]
];

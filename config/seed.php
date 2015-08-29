<?php
return [
    'i18n' => [
        [
            'id' => 1,
            'locale' => 'en',
            'model' => 'NotificationContents',
            'foreign_key' => 'fd77e860-dbe0-4e60-8939-56cc841cc3eb',
            'field' => 'email_subject',
            'content' => 'Reset your password'
        ],
        [
            'id' => 2,
            'locale' => 'en',
            'model' => 'NotificationContents',
            'foreign_key' => 'fd77e860-dbe0-4e60-8939-56cc841cc3eb',
            'field' => 'email_html',
            'content' => 'Dear {{user.firstname}} {{user.lastname}},
<br><br>
here\'s the link to reset your password: {{reset_password_link}}'
        ],

    ],
    'model_history' => [
        [
            'id' => 'a9c34634-463b-480a-949d-e477a641a44f',
            'model' => 'Users',
            'foreign_key' => 'ec3a29cf-063e-4e48-a9a0-0c266b4f8503',
            'user_id' => null,
            'action' => 'update',
            'data' => [
                'failed_login_count' => 0,
            ],
            'revision' => 1,
            'created' => '2015-08-29 12:51:51'
        ],
        [
            'id' => 'd90e5a27-41e5-4c20-869d-3c51c89b61f0',
            'model' => 'Users',
            'foreign_key' => 'ec3a29cf-063e-4e48-a9a0-0c266b4f8503',
            'user_id' => null,
            'action' => 'update',
            'data' => [
                'api_token' => '468d0f167486eaa131e747bb5c6c4eac',
            ],
            'revision' => 3,
            'created' => '2015-08-29 13:03:48'
        ],
        [
            'id' => 'f1d38228-c677-482a-b456-1c357cad2a52',
            'model' => 'Users',
            'foreign_key' => 'ec3a29cf-063e-4e48-a9a0-0c266b4f8503',
            'user_id' => null,
            'action' => 'update',
            'data' => [
                'failed_login_count' => 0,
            ],
            'revision' => 2,
            'created' => '2015-08-29 13:03:48'
        ],

    ],
    'notification_contents' => [
        [
            'id' => 'fd77e860-dbe0-4e60-8939-56cc841cc3eb',
            'notification_identifier' => 'forgot_password',
            'notes' => '{user.firstname} {user.lastname}',
            'created' => '2015-08-18 09:52:32',
            'modified' => '2015-08-18 09:52:32'
        ],

    ],
    'users' => [
        [
            'id' => 'ec3a29cf-063e-4e48-a9a0-0c266b4f8503',
            'status' => 'active',
            'role' => 'admin',
            'firstname' => 'John',
            'lastname' => 'Doe',
            'email' => 'john.doe@example.com',
            'password' => '$2y$10$mlTcJ4XIprOkM08qpH4qmO5NM1H4YLGyuBCLetkE3B0nsHJ3fxaFG',
            'failed_login_count' => 0,
            'failed_login_timestamp' => null,
            'api_token' => null,
            'created' => '2015-08-28 14:25:16',
            'modified' => '2015-08-29 13:03:48'
        ],

    ],
];

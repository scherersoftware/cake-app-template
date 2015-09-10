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
            'password' => '$2y$10$M8Mhbt2q2rwB49NeWApElO52lR2M1vVlom/cnxjoevuFUPuk.Mm0.',
            'failed_login_count' => 0,
            'failed_login_timestamp' => null,
            'api_token' => null,
            'created' => '2015-08-28 14:25:16',
            'modified' => '2015-09-09 09:04:40'
        ],

    ],
];

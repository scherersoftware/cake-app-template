<?php
use Phinx\Seed\AbstractSeed;

/**
 * Users seed.
 */
class UsersSeed extends AbstractSeed
{
    /**
     * Run Method.
     *
     * Write your database seeder using this method.
     *
     * More information on writing seeders is available here:
     * http://docs.phinx.org/en/latest/seeding.html
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'id' => 'ec3a29cf-063e-4e48-a9a0-0c266b4f8503',
                'status' => 'active',
                'role' => 'admin',
                'firstname' => 'John',
                'lastname' => 'Doe',
                'email' => 'john.doe@example.com',
                'password' => '$2y$10$Im.6sVvfio4Z.9MK1ceTzOoNAnxuxirVEkGVcbgIWXUC/OJ0KIJHK',
                'last_passwords' => '',
                'failed_login_count' => 0,
                'failed_login_timestamp' => null,
                'api_token' => null,
                'created' => date('Y-m-d H:i:s'),
                'modified' => date('Y-m-d H:i:s'),
            ]
        ];

        $table = $this->table('users');
        $table->insert($data)->save();
    }
}

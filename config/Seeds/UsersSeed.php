<?php
use Migrations\AbstractSeed;

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
                'id' => '125f53d8-129d-42c5-971d-edd0c6495dcc',
                'status' => 'active',
                'role' => 'admin',
                'firstname' => 'John',
                'lastname' => 'Doe',
                'email' => 'john.doe@example.com',
                'password' => $this->_getDefaultPassword(),
                'last_passwords' => null,
                'failed_login_count' => 0,
                'failed_login_timestamp' => null,
                'api_token' => null,
                'created' => '2016-11-11 11:11:11',
                'modified' => '2016-11-11 11:11:11'
            ],
        ];

        $table = $this->table('users');
        $table->insert($data)->save();
    }

    /**
     * Get the default password
     *
     * @return string
     */
    protected function _getDefaultPassword()
    {
        return (new \Cake\Auth\DefaultPasswordHasher())->hash('password');
    }
}

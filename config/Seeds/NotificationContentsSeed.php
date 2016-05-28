<?php
use Phinx\Seed\AbstractSeed;

/**
 * NotificationContents seed.
 */
class NotificationContentsSeed extends AbstractSeed
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
                'id' => 'fd77e860-dbe0-4e60-8939-56cc841cc3eb',
                'notification_identifier' => 'forgot_password',
                'notes' => '{user.firstname} {user.lastname}',
                'created' => '2015-08-18 09:52:32',
                'modified' => '2015-08-18 09:52:32'
            ],
        ];

        $table = $this->table('notification_contents');
        $table->insert($data)->save();
    }
}

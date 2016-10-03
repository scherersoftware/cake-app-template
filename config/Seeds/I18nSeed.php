<?php
use Phinx\Seed\AbstractSeed;

/**
 * I18n seed.
 */
class I18nSeed extends AbstractSeed
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
                'content' => 'Dear {{user.fullname}},
    <br><br>
    here\'s the link to reset your password: {{reset_password_link}}'
            ],
        ];

        $table = $this->table('i18n');
        $table->insert($data)->save();
    }
}

<?php
use Migrations\AbstractMigration;

class AddLastPasswordsToUsers extends AbstractMigration
{

    public function up()
    {

        $this->table('users')
            ->addColumn('last_passwords', 'text', [
                'default' => null,
                'length' => null,
                'null' => true,
            ])
            ->update();
    }

    public function down()
    {

        $this->table('users')
            ->removeColumn('last_passwords')
            ->update();
    }
}


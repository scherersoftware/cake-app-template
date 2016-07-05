<?php
use Migrations\AbstractMigration;

class AddJobsTable extends AbstractMigration
{

    public function up()
    {

        $this->table('jobs')
            ->addColumn('queue', 'string', [
                'default' => null,
                'limit' => 32,
                'null' => false,
            ])
            ->addColumn('data', 'text', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('priority', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => false,
            ])
            ->addColumn('expires_at', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('delay_until', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('locked', 'integer', [
                'default' => 0,
                'limit' => 1,
                'null' => false,
            ])
            ->addColumn('attempts', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => true,
            ])
            ->addIndex(
                [
                    'queue',
                    'locked',
                ]
            )
            ->create();

    }

    public function down()
    {

        $this->dropTable('jobs');
    }
}


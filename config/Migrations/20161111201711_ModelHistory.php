<?php
use Migrations\AbstractMigration;

class ModelHistory extends AbstractMigration
{

    public function up()
    {

        $this->table('model_history', ['id' => false, 'primary_key' => ['id']])
            ->addColumn('id', 'uuid', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('model', 'string', [
                'comment' => 'e.g. \"Installation\"',
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('foreign_key', 'uuid', [
                'comment' => 'uuid',
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('user_id', 'uuid', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('action', 'string', [
                'comment' => 'e.g. \"create\", \"update\", \"delete\"',
                'default' => null,
                'limit' => 45,
                'null' => true,
            ])
            ->addColumn('data', 'binary', [
                'comment' => 'JSON blob, schema per action',
                'default' => null,
                'limit' => 16777215,
                'null' => true,
            ])
            ->addColumn('revision', 'integer', [
                'default' => null,
                'limit' => 8,
                'null' => false,
            ])
            ->addColumn('created', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addIndex(
                [
                    'model',
                    'foreign_key',
                ]
            )
            ->create();
    }

    public function down()
    {

        $this->dropTable('model_history');
    }
}


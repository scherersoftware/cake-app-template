<?php
/**
 * This file is auto-generated from the current state of the database. Instead
 * of editing this file, please use the migrations to incrementally modify your
 * database, and then regenerate this schema definition.
 *
 * Note that this schema definition is the authoritative source for your
 * database schema. If you need to create the application database on another
 * system, you should be using `cake schema load`, not running all the migrations
 * from scratch. The latter is a flawed and unsustainable approach (the more migrations
 * you'll amass, the slower it'll run and the greater likelihood for issues).
 *
 * It's strongly recommended that you check this file into your version control system.
 */

// @codingStandardsIgnoreStart
return [
    'tables' => [
        'jobs' => [
            'id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'autoIncrement' => true, 'precision' => null],
            'queue' => ['type' => 'string', 'length' => 32, 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
            'data' => ['type' => 'text', 'length' => null, 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null],
            'priority' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
            'expires_at' => ['type' => 'datetime', 'length' => null, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
            'delay_until' => ['type' => 'datetime', 'length' => null, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
            'locked' => ['type' => 'integer', 'length' => 1, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
            'attempts' => ['type' => 'string', 'length' => 255, 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
            '_indexes' => [
                'is_locked' => ['type' => 'index', 'columns' => ['queue', 'locked'], 'length' => []],
            ],
            '_constraints' => [
                'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            ],
            '_options' => [
'engine' => 'InnoDB', 'collation' => 'utf8_general_ci'
            ],
        ],
        'josegonzalez_cake_queuesadilla_phinxlog' => [
            'version' => ['type' => 'biginteger', 'length' => 20, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
            'migration_name' => ['type' => 'string', 'length' => 100, 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
            'start_time' => ['type' => 'timestamp', 'length' => null, 'null' => false, 'default' => 'CURRENT_TIMESTAMP', 'comment' => '', 'precision' => null],
            'end_time' => ['type' => 'timestamp', 'length' => null, 'null' => false, 'default' => 'CURRENT_TIMESTAMP', 'comment' => '', 'precision' => null],
            '_constraints' => [
                'primary' => ['type' => 'primary', 'columns' => ['version'], 'length' => []],
            ],
            '_options' => [
'engine' => 'InnoDB', 'collation' => 'utf8_general_ci'
            ],
        ],
        'phinxlog' => [
            'version' => ['type' => 'biginteger', 'length' => 20, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
            'migration_name' => ['type' => 'string', 'length' => 100, 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
            'start_time' => ['type' => 'timestamp', 'length' => null, 'null' => false, 'default' => 'CURRENT_TIMESTAMP', 'comment' => '', 'precision' => null],
            'end_time' => ['type' => 'timestamp', 'length' => null, 'null' => false, 'default' => 'CURRENT_TIMESTAMP', 'comment' => '', 'precision' => null],
            '_constraints' => [
                'primary' => ['type' => 'primary', 'columns' => ['version'], 'length' => []],
            ],
            '_options' => [
'engine' => 'InnoDB', 'collation' => 'utf8_general_ci'
            ],
        ],
        'users' => [
            'id' => ['type' => 'uuid', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
            'status' => ['type' => 'string', 'length' => 255, 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
            'role' => ['type' => 'string', 'length' => 255, 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
            'firstname' => ['type' => 'string', 'length' => 255, 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
            'lastname' => ['type' => 'string', 'length' => 255, 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
            'email' => ['type' => 'string', 'length' => 255, 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
            'password' => ['type' => 'string', 'length' => 100, 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
            'last_passwords' => ['type' => 'text', 'length' => null, 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null],
            'failed_login_count' => ['type' => 'integer', 'length' => 3, 'unsigned' => false, 'null' => false, 'default' => '0', 'comment' => '', 'precision' => null, 'autoIncrement' => null],
            'failed_login_timestamp' => ['type' => 'datetime', 'length' => null, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
            'api_token' => ['type' => 'string', 'length' => 255, 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
            'created' => ['type' => 'datetime', 'length' => null, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
            'modified' => ['type' => 'datetime', 'length' => null, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
            '_constraints' => [
                'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            ],
            '_options' => [
'engine' => 'InnoDB', 'collation' => 'utf8_general_ci'
            ],
        ],

    ],
];

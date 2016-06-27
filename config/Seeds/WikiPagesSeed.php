<?php
use Phinx\Seed\AbstractSeed;

/**
 * WikiPages seed.
 */
class WikiPagesSeed extends AbstractSeed
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
                'parent_id' => null,
                'lft' => 1,
                'rght' => 4,
                'sort' => null,
                'title' => 'Top-Level Wiki Page',
                'content' => '# Wiki Page

    Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.',
                'status' => 1,
                'created' => '2016-03-18 13:37:06',
                'modified' => '2016-03-18 13:37:06'
            ],
            [
                'id' => 2,
                'parent_id' => 1,
                'lft' => 2,
                'rght' => 3,
                'sort' => null,
                'title' => 'Second-Level Wiki Page',
                'content' => '## Second Level

    Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.',
                'status' => 1,
                'created' => '2016-03-18 13:37:30',
                'modified' => '2016-03-18 13:37:30'
            ],
        ];

        $table = $this->table('wiki_pages');
        $table->insert($data)->save();
    }
}

<?php
use Phinx\Seed\AbstractSeed;

/**
 * CmsRows seed.
 */
class CmsRowsSeed extends AbstractSeed
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
                'id' => '7a8dc8ff-c3bb-4116-a2ab-440b45de775b',
                'cms_page_id' => '71650c0c-9ce6-4faa-9f8e-f7475e1a1e88',
                'layout' => '4-4-4',
                'position' => 1,
                'created' => '2015-09-15 07:29:29',
                'modified' => '2015-09-15 07:29:29'
            ],
        ];

        $table = $this->table('cms_rows');
        $table->insert($data)->save();
    }
}

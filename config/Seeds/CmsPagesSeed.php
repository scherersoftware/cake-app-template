<?php
use Phinx\Seed\AbstractSeed;

/**
 * CmsPages seed.
 */
class CmsPagesSeed extends AbstractSeed
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
                'id' => '71650c0c-9ce6-4faa-9f8e-f7475e1a1e88',
                'slug' => 'demo/content/cms-page',
                'name' => 'CMS Demo Page',
                'status' => 'active',
                'created' => '2015-09-15 07:29:23',
                'modified' => '2015-09-15 07:29:23'
            ],
        ];

        $table = $this->table('cms_pages');
        $table->insert($data)->save();
    }
}

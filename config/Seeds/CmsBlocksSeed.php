<?php
use Phinx\Seed\AbstractSeed;

/**
 * CmsBlocks seed.
 */
class CmsBlocksSeed extends AbstractSeed
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
                'id' => '01dab545-cd82-427e-a1d5-9763cb2ca7cb',
                'cms_row_id' => '7a8dc8ff-c3bb-4116-a2ab-440b45de775b',
                'status' => 'active',
                'column_index' => 1,
                'position' => 1,
                'widget' => 'Cms.Html',
                'block_data' => '{"html": "Hello"}',
                'created' => '2015-09-15 07:29:35',
                'modified' => '2015-09-15 07:29:45'
            ],
            [
                'id' => '1cf60b5a-84ff-4404-a6ee-299b37033f56',
                'cms_row_id' => '7a8dc8ff-c3bb-4116-a2ab-440b45de775b',
                'status' => 'active',
                'column_index' => 2,
                'position' => 1,
                'widget' => 'Cms.TinyMce',
                'block_data' => '{"html": "<p><strong>World</strong></p>"}',
                'created' => '2015-09-15 07:29:52',
                'modified' => '2015-09-15 07:30:11'
            ],
            [
                'id' => '66ea9935-6f1c-423a-9ab5-c2e2e4c54a3e',
                'cms_row_id' => '7a8dc8ff-c3bb-4116-a2ab-440b45de775b',
                'status' => 'active',
                'column_index' => 3,
                'position' => 1,
                'widget' => 'Cms.Html',
                'block_data' => '{"html": "Hello"}',
                'created' => '2015-09-15 07:30:21',
                'modified' => '2015-09-15 07:30:28'
            ],
        ];

        $table = $this->table('cms_blocks');
        $table->insert($data)->save();
    }
}

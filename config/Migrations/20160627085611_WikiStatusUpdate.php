<?php
use Migrations\AbstractMigration;

class WikiStatusUpdate extends AbstractMigration
{

    public function up()
    {
        $this->table('wiki_pages')
            ->changeColumn('status', 'string', [
                'default' => 'active',
                'length' => 255,
                'null' => false,
            ])
            ->update();
        $this->execute('UPDATE wiki_pages SET status = "active" WHERE status = "1"');
        $this->execute('UPDATE wiki_pages SET status = "deleted" WHERE status = "0"');
    }

    public function down()
    {
        $this->execute('UPDATE wiki_pages SET status = 1 WHERE status = "active"');
        $this->execute('UPDATE wiki_pages SET status = 0 WHERE status = "deleted"');
        $this->table('wiki_pages')
            ->changeColumn('status', 'integer', [
                'default' => 1,
                'length' => 3,
                'null' => false,
            ])
            ->update();
    }
}


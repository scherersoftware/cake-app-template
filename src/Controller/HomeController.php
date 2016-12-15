<?php
namespace App\Controller;

use Cake\Datasource\ConnectionManager;
use Cake\ORM\TableRegistry;

class HomeController extends AppController
{
    /**
     * Home
     *
     * @return void
     */
    public function index()
    {
        $this->viewBuilder()->layout(false);
        try {
            $phinxTable = TableRegistry::get('Phinxlog');
            $migratedApp = $phinxTable->find()
                ->where([
                    'migration_name' => 'Initial'
                ])
                ->count();

            $phinxJobsTable = TableRegistry::get('josegonzalez_cake_queuesadilla_phinxlog');
            $migratedQueue = $phinxJobsTable->find()
                ->where([
                    'migration_name' => 'CreateJobs'
                ])
                ->count();
            $userTable = TableRegistry::get('Users');
            $seeded = $userTable->find()
                ->where([
                    'email' => 'john.doe@example.com'
                ])
                ->count();
        } catch (\Exception $e) {
            $migratedApp = false;
            $migratedQueue = false;
            $seeded = false;
        }
        $this->set(compact('migratedApp', 'migratedQueue', 'seeded'));
    }
}

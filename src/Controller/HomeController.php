<?php
declare(strict_types = 1);
namespace App\Controller;

use Cake\Datasource\ConnectionManager;
use Cake\ORM\TableRegistry;
use Exception;

class HomeController extends AppController
{
    /**
     * Home
     *
     * @return void
     */
    public function index(): void
    {
        $this->viewBuilder()->layout(false);
        try {
            $phinxTable = TableRegistry::get('Phinxlog');
            $migratedApp = $phinxTable->find()
                ->where([
                    'migration_name' => 'Initial'
                ])
                ->count();
        } catch (Exception $e) {
            $migratedApp = false;
        }

        try {
            $phinxJobsTable = TableRegistry::get('josegonzalez_cake_queuesadilla_phinxlog');
            $migratedQueue = $phinxJobsTable->find()
                ->where([
                    'migration_name' => 'CreateJobs'
                ])
                ->count();
        } catch (Exception $e) {
            $migratedQueue = false;
        }

        try {
            $userTable = TableRegistry::get('Users');
            $seeded = $userTable->find()
                ->where([
                    'email' => 'john.doe@example.com'
                ])
                ->count();
        } catch (Exception $e) {
            $seeded = false;
        }

        $this->set(compact('migratedApp', 'migratedQueue', 'seeded'));
    }
}

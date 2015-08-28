<?php
namespace Admin\Controller;

use Cake\ORM\TableRegistry;

class DashboardController extends AppController
{
    /**
     * Index
     *
     * @return void
     */
    public function index()
    {
        $this->loadModel('Users');
        $usersCount = $this->Users->find()->count();
        $this->set(compact('usersCount'));
    }
}

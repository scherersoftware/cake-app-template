<?php
namespace Admin\Controller;

use App\Controller\AppController as BaseController;
use App\Model\Entity\User;

class AppController extends BaseController
{

    /**
     * initialize
     *
     * @return void
     */
    public function initialize()
    {
        parent::initialize();
        $this->Auth->config([
            'loginAction' => ['plugin' => 'Admin', 'controller' => 'Login', 'action' => 'login'],
            'loginRedirect' => ['plugin' => 'Admin', 'controller' => 'Dashboard', 'action' => 'index'],
            'logoutRedirect' => ['plugin' => 'Admin', 'controller' => 'Login', 'action' => 'login'],
            'authenticate' => [
                'Form' => [
                    'scope' => [
                        'role' => User::ROLE_ADMIN
                    ]
                ]
            ]
        ]);
    }
}

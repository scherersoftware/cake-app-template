<?php
namespace Admin\Controller;

use App\Controller\AppController as BaseController;
use App\Model\Entity\User;

class AppController extends BaseController
{

    public $helpers = [
        'CkTools.Menu'
    ];

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

    /**
     * {@inheritDoc}
     */
    public function beforeFilter(\Cake\Event\Event $event)
    {
        //don't show auth error if user isn't logged in
        if (!$this->Auth->user()) {
            $this->Auth->config('authError', false);
        }
    }
}

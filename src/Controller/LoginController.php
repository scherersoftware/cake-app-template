<?php
namespace App\Controller;

use App\Lib\Status;
use App\Model\Entity\SupplierProfile;
use App\Model\Entity\User;
use Cake\Event\EventManager;
use Cake\Routing\Router;

class LoginController extends AppController
{
    /**
     * beforeFilter event
     *
     * @param Event $event cake event
     * @return void
     */
    public function beforeFilter(\Cake\Event\Event $event)
    {
        $this->loadModel('Users');
        parent::beforeFilter($event);
    }

    /**
     * login method
     *
     * @return void
     */
    public function login()
    {
        if (!$this->request->session()->started()) {
            $this->request->session()->start();
        }
        if (!empty($this->request->query('redirectUrl'))) {
            $this->request->session()->write('Auth.redirect', $this->request->query('redirectUrl'));
        }
        $user = $this->Users->newEntity();
        if ($this->request->is('post')) {
            $userData = $this->Auth->identify();
            if ($userData) {
                if ($this->request->data['cookie']) {
                    $this->AuthUtils->addRememberMeCookie($userData['id']);
                }
                $this->Auth->setUser($userData);
                return $this->redirect($this->Auth->redirectUrl());
            } elseif ($this->Users->hasLoginRetriesLock($this->request->data)) {
                $this->Flash->error(__('login.login_retries_lock'));
            } else {
                $this->Users->increaseLoginRetries($this->request->data);
                $this->Flash->error(__('login.wrong_credentials'));
            }
        }
        $this->set('user', $user);
    }

    /**
     * logout method
     *
     * @return void
     */
    public function logout()
    {
        $this->Flash->success(__('login.you_have_been_logged_out'));
        if ($this->request->session()->started()) {
            $this->request->session()->destroy();
        }
        $this->AuthUtils->destroyRememberMeCookie();
        return $this->redirect($this->Auth->logout());
    }
}

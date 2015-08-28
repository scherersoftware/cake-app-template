<?php
namespace Admin\Controller;

use App\Lib\Status;

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
        $user = $this->Users->newEntity();
        if ($this->request->is('post')) {
            $userData = $this->Auth->identify();
            if ($userData && $userData['status'] == Status::ACTIVE) {
                $this->Auth->setUser($userData);
                $this->Auth->redirectUrl($this->Auth->config('loginRedirect'));
                return $this->redirect($this->Auth->redirectUrl());
            } elseif ($this->Users->hasLoginRetriesLock($this->request->data)) {
                $this->Flash->error(__('login.login_retries_lock'));
            } else {
                $this->Users->increaseLoginRetries($this->request->data);
                $this->Flash->error(__('login.wrong_credentials'));
            }
            unset($this->request->data['password']);
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
        return $this->redirect($this->Auth->logout());
    }
}

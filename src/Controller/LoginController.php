<?php
declare(strict_types = 1);
namespace App\Controller;

use App\Lib\Status;
use App\Model\Entity\User;
use Cake\Event\EventManager;
use Cake\Http\Response;
use Cake\I18n\Time;
use Cake\Routing\Router;
use Cake\Validation\Validation;

/**
 * @property \App\Model\Table\UsersTable $Users
 */
class LoginController extends AppController
{
    /**
     * beforeFilter event
     *
     * @param Event $event cake event
     * @return void
     */
    public function beforeFilter(\Cake\Event\Event $event): void
    {
        $this->loadModel('Users');
        parent::beforeFilter($event);
    }

    /**
     * login method
     *
     * @return \Cake\Http\Response|void Redirects on successful login, renders view otherwise.
     */
    public function login()
    {
        $this->viewBuilder()->layout('plain');
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
                if ($this->request->getData('cookie') !== null) {
                    $this->AuthUtils->addRememberMeCookie($userData['id']);
                }
                $this->Auth->setUser($userData);

                return $this->redirect($this->Auth->redirectUrl());
            } elseif ($this->Users->hasLoginRetriesLock($this->request->getData())) {
                $this->Flash->error(__('login.login_retries_lock'));
            } else {
                $this->Users->increaseLoginRetries($this->request->getData());
                $this->Flash->error(__('login.wrong_credentials'));
            }
        }
        $this->set('user', $user);
    }

    /**
     * logout method
     *
     * @return \Cake\Http\Response|void Redirects on logout.
     */
    public function logout(): Response
    {
        $this->Flash->success(__('login.you_have_been_logged_out'));
        if ($this->request->session()->started()) {
            $this->request->session()->destroy();
        }
        $this->AuthUtils->destroyRememberMeCookie();

        return $this->redirect($this->Auth->logout());
    }

    /**
     * new password for users
     *
     * @return \Cake\Http\Response|void Redirects when email was passed, renders view otherwise.
     */
    public function forgotPassword()
    {
        $this->viewBuilder()->layout('plain');
        if ($this->request->is('post')) {
            if ($this->request->getData('email') !== null && Validation::email($this->request->getData('email'))) {
                $user = $this->Users->getUserByEmail($this->request->getData('email'));

                if (!empty($user)) {
                    $this->Users->sendForgotPasswordEmail($user);
                }
                $this->Flash->default(__('login.restore_password_email_sent'), true);

                return $this->redirect([
                    'plugin' => null,
                    'controller' => 'login',
                    'action' => 'login'
                ]);
            } else {
                $this->Flash->error(__('login.email_required'));
            }
        }
    }

    /**
     * restores password
     *
     * @param string $userId userId
     * @param string $token token
     * @return \Cake\Http\Response|void Redirects on successful restore, renders view otherwise.
     */
    public function restorePassword(string $userId, string $token)
    {
        $this->viewBuilder()->layout('plain');
        if (!empty($userId) && !empty($token)) {
            $user = $this->Users->get($userId);
            if (!empty($user)) {
                $userHash = $this->Users->getHash($user);

                $timestamp = substr($token, -10);
                $hash = substr($token, 0, -10);
                $time = new Time($timestamp);
                $expire = '1 day';

                if (!($hash === $userHash && $time->wasWithinLast($expire))) {
                    $this->Flash->error(__('login.restore_password_link_invalid'));

                    return $this->redirect(['action' => 'login']);
                }
            }
            // Save new Password
            if ($this->request->is(['patch', 'post', 'put'])) {
                $user = $this->Users->resetPassword($user, $this->request->getData());
                if (empty($user->getErrors())) {
                    $this->Users->resetLoginRetries($user);
                    $this->Flash->success(__('login.new_password_saved'));

                    return $this->redirect(['action' => 'login']);
                } else {
                    $this->Flash->error(__('login.invalid_password'));
                }
            }
        } else {
            return $this->redirect(['action' => 'login']);
        }

        $this->request = $this->request
            ->withData('password', '')
            ->withData('password_confirm', '');

        $this->set(compact('user'));
    }
}

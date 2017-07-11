<?php
declare(strict_types = 1);
namespace App\Controller;

use App\Controller\AppController;

/**
 * @property \App\Model\Table\UsersTable $Users
 */
class ProfileController extends AppController
{
    /**
     * Index action, check old password and change it
     *
     * @return \Cake\Http\Response|void Redirects on successful user update, renders view otherwise.
     */
    public function index()
    {
        $this->loadModel('Users');
        $user = $this->Users->get($this->Auth->user('id'));
        unset($user->password);
        if ($this->request->is('put')) {
            $this->Users->changePassword($user, $this->request->getData());
            if (empty($user->getErrors())) {
                $this->Flash->success(__('profile.password_change_success'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('profile.password_change_failure'));
            }
        }
        $this->set('user', $user);
    }
}

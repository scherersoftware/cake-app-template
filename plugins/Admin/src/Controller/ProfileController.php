<?php
namespace Admin\Controller;

use Admin\Controller\AppController;

class ProfileController extends AppController
{
    /**
     * Index action, check old password and change it
     *
     * @return void
     */
    public function index()
    {
        $this->loadModel('Users');
        $user = $this->Users->get($this->Auth->user('id'));
        unset($user->password);
        if ($this->request->is('put')) {
            $user->accessible('*', false);
            $user->accessible(['password', 'password_confirm', 'current_password'], true);
            $this->Users->patchEntity($user, $this->request->data, ['validate' => 'changePassword']);
            if ($this->Users->save($user)) {
                $this->Flash->success(__('profile.password_change_success'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('profile.password_change_failure'));
            }
        }
        $this->set('user', $user);
    }
}

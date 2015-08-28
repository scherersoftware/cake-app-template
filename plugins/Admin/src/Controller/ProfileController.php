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
        if ($this->request->is('put')) {
            $user = $this->Users->changePassword($user, $this->request->data, true);
            if (false !== $user && !$user->errors()) {
                $this->Flash->success(__('profile.password_change_success'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('profile.password_change_failure'));
            }
        }
        $this->set('user', $user);
    }
}

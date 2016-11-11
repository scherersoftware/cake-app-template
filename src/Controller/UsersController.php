<?php
namespace App\Controller;

use App\Controller\AppController;
use App\Model\Entity\User;

/**
 * Users Controller
 *
 * @property \App\Model\Table\UsersTable $Users
 */
class UsersController extends AppController
{

    /**
     * Provides ListFilter configuration
     *
     * @return array
     */
    public function getListFilters()
    {
        $filters = [];
        if ($this->request->action == 'index') {
            $filters['fields'] = [
                'Users.role' => [
                    'searchType' => 'select',
                    'options' => User::getRoles(),
                    'inputOptions' => [
                        'label' => __('user.role')
                    ]
                ],
                'Users.status' => [
                    'searchType' => 'select',
                    'options' => User::getStatuses(),
                    'inputOptions' => [
                        'label' => __('user.status')
                    ]
                ],
                'Users.fulltext' => [
                    'searchType' => 'fulltext',
                    'searchFields' => [
                        'Users.firstname',
                        'Users.lastname',
                        'Users.email'
                    ]
                ]
            ];
        }

        return $filters;
    }

    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {
        $users = $this->paginate($this->Users);

        $this->set(compact('users'));
        $this->set('_serialize', ['users']);
    }

    /**
     * View method
     *
     * @param string|null $id User id.
     * @return void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $user = $this->Users->get($id, [
            'contain' => []
        ]);

        $this->set('user', $user);
        $this->set('_serialize', ['user']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $user = $this->Users->newEntity();
        if ($this->request->is('post')) {
            $user = $this->Users->patchEntity($user, $this->request->data);
            if ($this->Users->save($user)) {
                $this->Flash->success(__('forms.data_saved'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('forms.data_not_saved'));
            }
        }
        $this->set(compact('user'));
        $this->set('_serialize', ['user']);
    }

    /**
     * Edit method
     *
     * @param string|null $id User id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $user = $this->Users->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $user = $this->Users->patchEntity($user, $this->request->data);
            if ($this->Users->save($user)) {
                $this->Flash->success(__('forms.data_saved'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('forms.data_not_saved'));
            }
        }
        $this->set(compact('user'));
        $this->set('_serialize', ['user']);
    }

    /**
     * Delete method
     *
     * @param string|null $id User id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $user = $this->Users->get($id);
        if ($this->Users->softDelete($user)) {
            $this->Flash->success(__('forms.data_deleted'));
        } else {
            $this->Flash->error(__('forms.data_not_deleted'));
        }

        return $this->redirect(['action' => 'index']);
    }
}

<?php
namespace Api\V2\Controller;

use CakeApiBaselayer\Lib\ApiReturnCode;

class UsersController extends AppController
{

    /**
     * Initializer
     *
     * @return void
     */
    public function initialize()
    {
        $this->loadModel('Users');
        parent::initialize();
    }

    /**
     * Authenticate
     *
     * @return ServiceResponse
     */
    public function authenticate()
    {
        $this->request->allowMethod('post');
        if (!isset($this->request->data['email']) || !isset($this->request->data['password'])) {
            return $this->Api->response(ApiReturnCode::INVALID_PARAMS);
        }
        if ($this->Auth->user()) {
            $this->Auth->logout();
        }
        if ($user = $this->Auth->identify()) {
            if (empty($user['api_token'])) {
                $userEntity = $this->Users->get($user['id']);
                $userEntity->api_token = $this->Api->generateApiToken();
                $this->Users->save($userEntity);
                $user['api_token'] = $userEntity->api_token;
            }
            $this->Auth->setUser($user);
            return $this->Api->response(ApiReturnCode::SUCCESS, [
                'user' => [
                    'id' => $user['id'],
                    'api_token' => $user['api_token']
                ]
            ]);
        } else {
            $this->Users->increaseLoginRetries($this->request->data);
            return $this->Api->response(ApiReturnCode::INVALID_CREDENTIALS);
        }
    }

    /**
     * Kills the current session
     *
     * @return void
     */
    public function logout()
    {
        $this->request->allowMethod('get');
        $this->Auth->logout();
        return $this->Api->response(ApiReturnCode::SUCCESS);
    }

    /**
     * Returns the current user's data.
     *
     * @return Response
     */
    public function current()
    {
        $this->request->allowMethod('get');
        if (!$this->Auth->user()) {
            return $this->Api->response(ApiReturnCode::NOT_AUTHENTICATED);
        }
        $user = $this->Users->get($this->Auth->user('id'));
        return $this->Api->response(ApiReturnCode::SUCCESS, [
            'user' => $user->toArray()
        ]);
    }
}

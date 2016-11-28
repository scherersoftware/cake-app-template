<?php

namespace Api\V1\Controller;

use CakeApiBaselayer\Lib\ApiReturnCode;

class UsersController extends AppController
{

    /**
     * Authenticate
     *
     * @return ServiceResponse
     */
    public function authorize()
    {
        $this->request->allowMethod('post');
        if (!isset($this->request->data['email']) || !isset($this->request->data['password'])) {
            return $this->Api->response(ApiReturnCode::INVALID_PARAMS);
        }
        if ($this->Auth->user()) {
            $this->Auth->logout();
        }
        if ($user = $this->Auth->identify()) {
            $userEntity = $this->Users->get($user['id']);
            if (empty($user['api_token'])) {
                $userEntity->api_token = $this->Api->generateApiToken();
                $this->Users->save($userEntity);
                $user['api_token'] = $userEntity->api_token;
            }
            $this->Auth->setUser($user);

            return $this->Api->response(ApiReturnCode::SUCCESS, [
                'user' => $userEntity->apiTransform()
            ]);
        } else {
            $this->Users->increaseLoginRetries($this->request->data);

            return $this->Api->response(ApiReturnCode::INVALID_CREDENTIALS);
        }
    }

    /**
     * Logout User and revoke api token
     *
     * @return ServiceResponse
     */
    public function revoke()
    {
        $this->request->allowMethod('patch');
        $this->Api->logout();
        return $this->Api->response(ApiReturnCode::SUCCESS);
    }

    /**
     * Returns the current user's data.
     *
     * @return ServiceResponse
     */
    public function current()
    {
        $this->request->allowMethod('get');
        $user = $this->Users->get($this->Auth->user('id'));

        return $this->Api->response(ApiReturnCode::SUCCESS, [
            'user' => $user->apiTransform()
        ]);
    }

    /**
     * Forget Password
     *
     * @return ServiceResponse
     */
    public function forgotPassword()
    {
        $this->loadModel('Users');
        $this->request->allowMethod('post');
        if (!isset($this->request->data['email'])) {
            return $this->Api->response(ApiReturnCode::INVALID_PARAMS);
        }

        $user = $this->Users->getUserByEmail($this->request->data['email']);
        if (empty($user)) {
            return $this->Api->response(ApiReturnCode::INVALID_CREDENTIALS);
        }

        $this->Users->sendForgotPasswordEmail($user);

        return $this->Api->response(ApiReturnCode::SUCCESS);
    }

    /**
     * Change Password
     *
     * @return ServiceResponse
     */
    public function changePassword()
    {
        $this->loadModel('Users');
        $this->request->allowMethod('post');

        if (!isset($this->request->data['current_password']) || !isset($this->request->data['password']) || !isset($this->request->data['password_confirm'])) {
            return $this->Api->response(ApiReturnCode::INVALID_PARAMS);
        }

        $user = $this->Users->get($this->Auth->user('id'));
        $user = $this->Users->changePassword($user, $this->request->data);

        if ($this->Api->checkForErrors($user)) {
            return $this->Api->response(ApiReturnCode::VALIDATION_FAILED, [
                'errors' => $user->errors()
            ]);
        }

        return $this->Api->response(ApiReturnCode::SUCCESS);
    }
}

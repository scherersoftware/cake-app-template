<?php
declare(strict_types = 1);

namespace Api\V1\Controller;

use CakeApiBaselayer\Lib\ApiReturnCode;
use Cake\Http\Response;

class UsersController extends AppController
{

    /**
     * Authenticate
     *
     * @return ServiceResponse
     */
    public function authorize(): Response
    {
        $this->request->allowMethod('post');
        if ($this->request->getData('email') === null || $this->request->getData('password') === null) {
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
            $this->Users->increaseLoginRetries($this->request->getData());

            return $this->Api->response(ApiReturnCode::INVALID_CREDENTIALS);
        }
    }

    /**
     * Logout User and revoke api token
     *
     * @return ServiceResponse
     */
    public function revoke(): Response
    {
        $this->request->allowMethod('patch');
        $this->Api->logout();

        return $this->Api->response(ApiReturnCode::SUCCESS);
    }

    /**
     * Forget Password
     *
     * @return ServiceResponse
     */
    public function forgotPassword(): Response
    {
        $this->loadModel('Users');
        $this->request->allowMethod('post');
        if ($this->request->getData('email') === null) {
            return $this->Api->response(ApiReturnCode::INVALID_PARAMS);
        }

        $user = $this->Users->getUserByEmail($this->request->getData('email'));
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
    public function changePassword(): Response
    {
        $this->loadModel('Users');
        $this->request->allowMethod('post');

        if ($this->request->getData('current_password') === null || $this->request->getData('password') === null || $this->request->getData('password_confirm') === null) {
            return $this->Api->response(ApiReturnCode::INVALID_PARAMS);
        }

        $user = $this->Users->get($this->Auth->user('id'));
        $user = $this->Users->changePassword($user, $this->request->getData());

        if ($this->Api->checkForErrors($user)) {
            return $this->Api->response(ApiReturnCode::VALIDATION_FAILED, [
                'errors' => $user->errors()
            ]);
        }

        return $this->Api->response(ApiReturnCode::SUCCESS);
    }
}

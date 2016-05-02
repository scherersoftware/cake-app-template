<?php
namespace Api\V1\Controller;

use CakeApiBaselayer\Controller\AppController as BaseController;
use CakeApiBaselayer\Lib\ApiReturnCode;
use Cake\Routing\Router;

class AppController extends BaseController
{
    /**
     * Initialization Hook.
     *
     * @return void
     */
    public function initialize()
    {
        parent::initialize();
    }

    /**
     * {@inheritDoc}
     */
    public function beforeFilter(\Cake\Event\Event $event)
    {
        parent::beforeFilter($event);
    }

    /**
     * {@inheritDoc}
     */
    public function redirect($url, $status = null)
    {
        if (Router::normalize($this->Auth->config('loginAction')) == Router::normalize($url)) {
            return $this->Api->response(ApiReturnCode::NOT_AUTHENTICATED);
        }
        return parent::redirect($url, $status);
    }
}

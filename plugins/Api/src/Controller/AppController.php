<?php
namespace Api\Controller;

use App\Controller\AppController as BaseController;
use Cake\Routing\Router;
use CkTools\Lib\ApiReturnCode;

class AppController extends BaseController
{
    /**
     * Initialization Hook.
     *
     * @return void
     */
    public function initialize()
    {
        $this->loadModel('Users');
        $this->loadComponent('RequestHandler');
        $this->loadComponent('CkTools.Api');
        parent::initialize();
    }

    /**
     * {@inheritDoc}
     */
    public function beforeFilter(\Cake\Event\Event $event)
    {
        $this->Api->setup();
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

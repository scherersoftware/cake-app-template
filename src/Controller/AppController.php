<?php
declare(strict_types = 1);
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link      http://cakephp.org CakePHP(tm) Project
 * @since     0.2.9
 * @license   http://www.opensource.org/licenses/mit-license.php MIT License
 */
namespace App\Controller;

use Cake\Controller\Controller;
use Cake\Event\Event;
use Cake\Http\Response;

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @link http://book.cakephp.org/3.0/en/controllers.html#the-app-controller
 * @property \App\Model\Table\UsersTable $Users
 * @property \FrontendBridge\Controller\Component\FrontendBridgeComponent $FrontendBridge
 * @property \ListFilter\Controller\Component\ListFilterComponent $ListFilter
 * @property \AuthActions\Controller\Component\AuthUtilsComponent $AuthUtils
 * @property \CakeApiBaselayer\Controller\Component\ApiComponent $Api
 */
class AppController extends Controller
{

    use \AuthActions\Lib\AuthActionsTrait;
    use \FrontendBridge\Lib\FrontendBridgeTrait;

    /**
     * Load components
     *
     * @var string[]
     */
    public $components = [
        'Flash',
        'FrontendBridge.FrontendBridge',
        'ListFilter.ListFilter',
        'Cookie',
        'AuthActions.AuthUtils',
        'CakeApiBaselayer.Api'
    ];

    /**
     * Initialization hook method.
     *
     * Use this method to add common initialization code like loading components.
     *
     * @return void
     */
    public function initialize(): void
    {
        $this->loadComponent('RequestHandler');
        $this->loadComponent('Auth', [
            'authenticate' => [
                'Form' => [
                    'fields' => ['username' => 'email'],
                    'repository' => 'Users',
                    'finder' => 'auth'
                ]
            ],
            'authorize' => ['Controller'],
            'loginAction' => ['plugin' => false, 'controller' => 'Login', 'action' => 'login'],
            'loginRedirect' => ['plugin' => false, 'controller' => 'Dashboard', 'action' => 'index'],
            'logoutRedirect' => ['plugin' => false, 'controller' => 'Home', 'action' => 'index'],
            'authError' => __('auth.not_allowed'),
            'flash' => [
                'params' => [
                    'class' => 'alert alert-warning'
                ]
            ],
        ]);
        /*
         * Enable the following components for recommended CakePHP security settings.
         * see http://book.cakephp.org/3.0/en/controllers/components/security.html
         */
        //$this->loadComponent('Security');
        //$this->loadComponent('Csrf');

        parent::initialize();
    }

    /**
     * Called before the controller action. You can use this method to configure and customize components
     * or perform logic that needs to happen before each controller action.
     *
     * @param \Cake\Event\Event $event An Event instance
     * @return \Cake\Http\Response|null|void
     */
    public function beforeFilter(\Cake\Event\Event $event)
    {
        $this->initAuthActions();
        $this->loadModel('Users');
        $this->Auth->eventManager()->attach([$this->Users, 'resetLoginRetriesListener'], 'Auth.afterIdentify');

        if (!$this->AuthUtils->loggedIn() && $userId = $this->AuthUtils->checkRememberMeCookie()) {
            $this->loadModel('Users');
            $user = $this->Users->get($userId)->toArray();
            $this->Auth->setUser($user);
        }

        if (!$this->Auth->user()) {
            $this->Auth->setConfig('authError', false);
        }

        parent::beforeFilter($event);
    }

    /**
     * Instantiates the correct view class, hands it its data, and uses it to render the view output.
     *
     * @param string|null $view View to use for rendering
     * @param string|null $layout Layout to use
     * @return \Cake\Http\Response A response object containing the rendered view.
     * @phpcsSuppress SlevomatCodingStandard.TypeHints.TypeHintDeclaration.MissingParameterTypeHint
     */
    public function render($view = null, $layout = null): Response
    {
        if ($this->request->is('json')) {
            return $this->renderJsonAction($view, $layout);
        }

        return parent::render($view, $layout);
    }

    /**
     * Redirects to given $url, after turning off $this->autoRender.
     *
     * @param string|string[] $url A string or array-based URL pointing to another location within the app,
     *     or an absolute URL
     * @param int $status HTTP status code (eg: 301)
     * @return \Cake\Http\Response|null
     * @phpcsSuppress SlevomatCodingStandard.TypeHints.TypeHintDeclaration.MissingParameterTypeHint
     * @phpcsSuppress SlevomatCodingStandard.TypeHints.TypeHintDeclaration.MissingReturnTypeHint
     */
    public function redirect($url, $status = 302)
    {
        if ($this->request->is('json')) {
            return $this->redirectJsonAction($url);
        }

        return parent::redirect($url, $status);
    }
}

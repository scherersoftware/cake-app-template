<?php
namespace App\Controller;

use App\Lib\NotificationHandler;
use App\Lib\Status;
use App\Model\Entity\User;
use Cake\Controller\Controller;
use Cake\Core\Configure;

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @link http://book.cakephp.org/3.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller
{

    use \AuthActions\Lib\AuthActionsTrait;
    use \FrontendBridge\Lib\FrontendBridgeTrait;

    public $helpers = [
        'Html' => [
            'className' => 'BootstrapUI.Html'
        ],
        'Form' => [
            'className' => 'BootstrapForm'
        ],
        'Paginator' => [
            'className' => 'BootstrapUI.Paginator'
        ],
        'Flash' => [
            'className' => 'BootstrapUI.Flash'
        ],
        'Auth' => ['className' => 'AuthActions.Auth'],
        'FrontendBridge' => ['className' => 'FrontendBridge.FrontendBridge'],
        'ModelHistory.ModelHistory',
        'CkTools.CkTools',
        'CkTools.TinyMce',
        'ListFilter.ListFilter',
        'AssetCompress.AssetCompress',
        'Attachments.Attachments',
        'ADmad/Glide.Glide'
    ];

    public $components = [
        'Flash',
        'FrontendBridge.FrontendBridge',
        'ListFilter.ListFilter',
        'Cookie',
        'AuthActions.AuthUtils',
        'CkTools.Api'
    ];

    /**
     * Initialization hook method.
     *
     * Use this method to add common initialization code like loading components.
     *
     * @return void
     */
    public function initialize()
    {
        $this->loadComponent('RequestHandler');
        $this->loadComponent('Auth', [
            'authenticate' => [
                'Form' => [
                    'fields' => ['username' => 'email'],
                    'repository' => 'Users',
                    'scope' => [
                        'Users.status' => Status::ACTIVE,
                        'Users.failed_login_count <' => Configure::read('Authentication.max_login_retries')
                    ]
                ]
            ],
            'authorize' => ['Controller'],
            'loginAction' => ['plugin' => false, 'controller' => 'Login', 'action' => 'login'],
            'loginRedirect' => ['plugin' => false, 'controller' => 'Home', 'action' => 'view'],
            'logoutRedirect' => ['plugin' => false, 'controller' => 'Login', 'action' => 'login'],
            'authError' => 'Sie sind nicht berechtigt diese Seite zu öffnen',
            'flash' => [
                'params' => [
                    'class' => 'alert alert-warning'
                ]
            ],
        ]);
        parent::initialize();
    }

    /**
     * {@inheritDoc}
     */
    public function beforeFilter(\Cake\Event\Event $event)
    {
        $this->initAuthActions();
        $this->loadModel('Users');
        $this->Auth->eventManager()->attach([$this->Users, 'resetLoginRetriesListener'], 'Auth.afterIdentify');

        if (PHP_SAPI !== 'cli') {
            $notificationHandler = new NotificationHandler();
            $notificationHandler->handleEvents();
        }

        $this->_apiTokenAuthentication();
        $this->FrontendBridge->setJson('locale', 'de');
        parent::beforeFilter($event);
    }

    /**
     * {@inheritDoc}
     */
    public function render($view = null, $layout = null)
    {
        if ($this->_isJsonActionRequest()) {
            return $this->renderJsonAction($view, $layout);
        }
        return parent::render($view, $layout);
    }

    /**
     * Handles authentication via the ApiToken header.
     *
     * @return void
     */
    protected function _apiTokenAuthentication()
    {
        if ($token = $this->request->header('APITOKEN')) {
            if (!$this->Auth->user() || $this->Auth->user('api_token') !== $token) {
                $user = $this->Users->getByApiToken($token);
                if ($user) {
                    $this->Auth->setUser($user->toArray());
                } else {
                    $this->Auth->logout();
                }
            }
        }
    }
}

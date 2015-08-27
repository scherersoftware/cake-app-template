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
        'Utils' => ['className' => 'Utils'],
        'Auth' => ['className' => 'AuthActions.Auth'],
        'FrontendBridge' => ['className' => 'FrontendBridge.FrontendBridge'],
        'ModelHistory.ModelHistory',
        'CkTools.CkTools',
        'ListFilter.ListFilter',
        'AssetCompress.AssetCompress',
        'Attachments.Attachments'
    ];

    public $components = [
        'Flash',
        'FrontendBridge.FrontendBridge',
        'ListFilter.ListFilter',
        'Cookie',
        'AuthActions.AuthUtils'
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
                        'role' => User::ROLE_USER,
                        'status' => Status::ACTIVE,
                        'failed_login_count <' => Configure::read('Authentication.max_login_retries')
                    ]
                ],
            ],
            'authorize' => ['Controller'],
            'loginAction' => ['plugin' => false, 'controller' => 'Login', 'action' => 'login'],
            'loginRedirect' => ['plugin' => false, 'controller' => 'Home', 'action' => 'index'],
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

        // $this->_apiTokenAuthentication();
        $this->FrontendBridge->setJson('locale', 'de');
    }

    /**
     * handle facebook/google logins, register with its cases and redirects
     *
     * @return void
     */
    public function authenticated()
    {
        $result = $this->Auth->identify();

        // user already exists, so redirect him like after normal login
        if (!empty($result['id'])) {
            return $this->redirect($this->Auth->redirectUrl());
        }

        // it's an attempt to register by social login
        // so we definitely need an email
        if (empty($result['email'])) {
            throw new \Cake\Core\Exception\Exception(__('login.no_email_received'));
        }

        $provider = __('login.social_login_provider');
        if (!empty($result['profileURL'])) {
            $provider = $this->Users->extractProvider($result['profileURL']);
        }
        $emailExistsQuery = $this->Users->find()
            ->where([
                'email' => $result['email']
            ]);
        // check if user with this email already exist
        if ($emailExistsQuery->count() > 0) {
            // then, there certainly is a reason why he wasn't identified in the first place
            $user = $emailExistsQuery->first();

            // user exists but has another role than user
            if ($user->role !== User::ROLE_USER) {
                $this->Flash->error(__('login.email_used'));
                return $this->redirect($this->Auth->logout());
            }
            // user exists but has no active status
            if ($user->status !== Status::ACTIVE) {
                $this->Flash->error(__('login.wrong_status'));
                return $this->redirect($this->Auth->logout());
            }

            if (!empty($result['identifier'])) {
                // check if the provider and the provider identifier match the existing account
                if ($user->provider !== $provider || $user->provider_uid !== $result['identifier']) {
                    if (empty($user->provider) && empty($user->provider_uid)) {
                        // user exists but registered the old fashioned way and not via social login
                        // log him in for convenience reasons
                        $this->Auth->setUser($user->toArray());
                        return $this->redirect($this->Auth->redirectUrl());
                    }
                    // user exists but used another social login for registration than for this login attempt
                    $this->Flash->error(__('login.existing_account_but_wrong_social_account_used'));
                    return $this->redirect($this->Auth->logout());
                }
            }
            // at this point, the account exists and everything is fine, but then Auth->identify() should have
            // identified him correctly and we should not be here
            throw new \Cake\Core\Exception\Exception(__('login.something_went_wrong'));
        } //end if user with this email already exist

        // create new account
        $user = $this->Users->registerThirdPartyUser($result);
        if (empty($user->errors())) {
            // log the newly created user in
            $this->request->session()->delete($this->Auth->sessionKey);
            $this->Auth->setUser($user->toArray());

            return $this->redirect([
                'plugin' => false,
                'controller' => 'login',
                'action' => 'completeRegistration'
            ]);
        } else {
            // data from third party were not enough to register user or validation failed
            $this->Flash->error(__('login.could_not_create_user_from_provider_data', $provider));
            return $this->redirect($this->Auth->logout());
        }
    }

    /**
     * {@inheritDoc}
     */
    public function beforeRender(\Cake\Event\Event $event)
    {
        parent::beforeRender($event);
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
     * handles the case of requesting a login action but being logged in already
     * by redirecting depending on role of the user
     *
     * @return void
     */
    protected function _handleAlreadyLoggedIn()
    {
        if (!empty($this->Auth->user('id'))) {
            $this->Flash->default(__('login.already_logged_in'));

            switch ($this->Auth->user('role')) {
                case User::ROLE_ADMIN:
                    return $this->redirect('/admin');
                    break;
                case User::ROLE_USER:
                    return $this->redirect($this->Auth->redirectUrl());
                    break;

                default:
                    return $this->redirect('/');
                    break;
            }
        }
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

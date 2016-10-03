<?php
namespace App\Lib;

use Cake\Core\Configure;
use Cake\Datasource\ModelAwareTrait;
use Cake\Event\Event;
use Cake\Event\EventManager;
use Cake\I18n\Time;
use Cake\Orm\TableRegistry;
use Cake\Routing\Router;

class NotificationHandler
{
    use ModelAwareTrait;

    /**
     * Configure the instance
     *
     */
    public function __construct()
    {
        if (defined('PHPUNIT_TESTSUITE') == 1) {
            return;
        }
        // $this->NotificationQueue = \Cake\Orm\TableRegistry::get('Notifications.NotificationQueue');
        $config = TableRegistry::exists('NotificationQueue') ? [] : ['className' => 'Notifications\Model\Table\NotificationQueueTable'];
        $this->NotificationQueue = TableRegistry::get('NotificationQueue', $config);
        $this->Users = TableRegistry::get('Users');
    }

    /**
     * Attaches to Event topics and attaches them to the corresponding event handlers
     *
     * @return void
     */
    public function handleEvents()
    {
        if (defined('PHPUNIT_TESTSUITE') == 1) {
            return;
        }
        $manager = EventManager::instance();
        $manager->attach([$this, 'onForgotPassword'], 'Users.forgot_password');
    }

    /**
     * forgot password email
     *
     * @param  Event                  $cakeEvent The CakePHP event
     * @param  \App\Model\Entity\User $user      the user entity
     * @return void
     */
    public function onForgotPassword(Event $cakeEvent, \App\Model\Entity\User $user)
    {
        $hash = $this->Users->getHash($user);
        $token = ($hash . strtotime('now'));
        $restoreLink = Router::url([
            'plugin' => 'Admin',
            'controller' => 'Login',
            'action' => 'restorePassword',
            $user->id,
            $token
        ], true);

        $data = [
            'locale' => 'en',
            'recipient_user_id' => $user->id,
            'transport' => 'email',
            'config' => [
                'reset_password_link' => $restoreLink,
                'user.fullname' => $user->full_name,
            ]
        ];
        $notification = $this->NotificationQueue->createNotification('forgot_password', $data, true);
    }
}

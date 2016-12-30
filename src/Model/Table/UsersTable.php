<?php
namespace App\Model\Table;

use App\Lib\Status;
use App\Model\Entity\User;
use Cake\Auth\DefaultPasswordHasher;
use Cake\Core\Configure;
use Cake\Database\Expression\QueryExpression;
use Cake\Datasource\EntityInterface;
use Cake\Event\Event;
use Cake\I18n\Time;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Routing\Router;
use Cake\Validation\Validator;
use Notifications\Notification\EmailNotification;

/**
 * Users Model
 *
 * @method \App\Model\Entity\User get($primaryKey, $options = [])
 * @method \App\Model\Entity\User newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\User[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\User|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\User patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\User[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\User findOrCreate($search, callable $callback = null)
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class UsersTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->table('users');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->addBehavior('Timestamp');
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator)
    {
        $validator
            ->uuid('id')
            ->allowEmpty('id', 'create');

        $validator
            ->requirePresence('status', 'create')
            ->notEmpty('status');

        $validator
            ->requirePresence('role', 'create')
            ->notEmpty('role');

        $validator
            ->requirePresence('firstname', 'create')
            ->notEmpty('firstname');

        $validator
            ->requirePresence('lastname', 'create')
            ->notEmpty('lastname');

        $validator
            ->email('email')
            ->requirePresence('email', 'create')
            ->notEmpty('email');

        $validator
            ->allowEmpty('password', 'update');

        $this->validationPassword($validator);

        $validator
            ->integer('failed_login_count')
            ->requirePresence('failed_login_count', 'create')
            ->notEmpty('failed_login_count');

        $validator
            ->dateTime('failed_login_timestamp')
            ->allowEmpty('failed_login_timestamp');

        $validator
            ->allowEmpty('api_token');

        $validator
            ->allowEmpty('last_passwords');

        return $validator;
    }

    /**
     * Validation for the change password process
     *
     * @param Validator $validator Validator
     * @return Validator
     */
    public function validationChangePassword(Validator $validator)
    {
        $validator->requirePresence('password');
        $validator->requirePresence('password_confirm');
        $validator->requirePresence('current_password');
        $validator->notEmpty('password');
        $validator->notEmpty('password_confirm');
        $validator->notEmpty('current_password');
        $validator->add('current_password', 'custom', [
            'rule' => function ($value, $context) {
                $user = $this->get($context['data']['id']);

                return (new DefaultPasswordHasher)->check($value, $user->password);
            },
            'message' => __('validation.user.old_password_wrong')
        ]);
        $this->validationPassword($validator, true);

        return $validator;
    }

    /**
     * Validation for the reset password process
     *
     * @param Validator $validator Validator
     * @return Validator
     */
    public function validationResetPassword(Validator $validator)
    {
        $validator->requirePresence('password');
        $validator->requirePresence('password_confirm');
        $validator->notEmpty('password');
        $validator->notEmpty('password_confirm');
        $this->validationPassword($validator, true);

        return $validator;
    }

    /**
     * Validation for password changes
     *
     * @param Validator $validator Validator
     * @param bool $force Whether to require validation in all cases
     * @return Validator
     */
    public function validationPassword(Validator $validator, $force = false)
    {
        $shouldValidate = function ($context) use ($force) {
            if ($force) {
                return true;
            }

            return $context['newRecord'] || !empty($context['data']['password']);
        };
        $validator
            ->notEmpty('password', __('validation.user.enter_new_password'), $shouldValidate)
            ->notEmpty('password_confirm', __('validation.user.repeat_new_password'), $shouldValidate)
            ->add('password', [
                'minLength' => [
                    'rule' => ['minLength', 8],
                    'last' => true,
                    'message' => __('validation.user.password_min_length')
                ],
            ])
            ->add('password_confirm', 'custom', [
                'rule' => function ($value, $context) {
                    return isset($context['data']['password']) && $value === $context['data']['password'];
                },
                'message' => __('validation.user.password_confirmation_must_match')
            ]);

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules)
    {
        $rules->add($rules->isUnique(['email']));

        return $rules;
    }

    /**
     * beforeSave callback
     *
     * @param Event $event CakePHP Event
     * @param Entity $entity Entity to be saved
     * @param ArrayObject $options Additional options
     * @return void
     */
    public function beforeSave(Event $event, EntityInterface $entity, \ArrayObject $options)
    {
        // When editing, remove passwords if nothing was entered
        if (empty($entity->password)) {
            unset($entity->password, $entity->password_confirm);
        }
    }

    /**
     * Reset the login retries counter
     *
     * @param User $user User Entity
     * @return mixed
     */
    public function resetLoginRetries(User $user)
    {
        $user->failed_login_count = 0;
        $user->failed_login_timestamp = null;

        return $this->save($user);
    }

    /**
     * check if the user with the email from the reuqestData exists and is locked from
     * login in because of a too high failed login count
     *
     * @param  array $requestData the request data array
     * @return bool
     */
    public function hasLoginRetriesLock($requestData)
    {
        if (!empty($requestData['email'])) {
            $user = $this->getUserByEmail($requestData['email']);
            if (!empty($user) && $user->failed_login_count >= Configure::read('Authentication.max_login_retries')) {
                return true;
            }
        }

        return false;
    }

    /**
     * Attached to the Auth.afterIdentify event to call the resetLoginRetries method
     *
     * @param Event $event CakePHP Event
     * @param array $userData Array with user data
     * @return void
     */
    public function resetLoginRetriesListener(\Cake\Event\Event $event, array $userData)
    {
        if (isset($userData['id'])) {
            $user = $this->get($userData['id']);
            $this->resetLoginRetries($user);
        }
    }

    /**
     * return User data by Email
     *
     * @param string $email id
     * @return object
     */
    public function getUserByEmail($email)
    {
        return $this->find()
            ->where([
                'status' => Status::ACTIVE,
                'email' => $email
            ])
            ->first();
    }

    /**
     * This should be called after a failed login attempt. If a record with the given user
     * email address exists and it was not created with social login, failed_login_count
     * will be increased and the failed_login_timestamp is set to now.
     *
     * @param array $requestData Request Data
     * @return bool Returns true if a user was found and the failed_login_count was increased
     */
    public function increaseLoginRetries(array $requestData)
    {
        if (!empty($requestData['email'])) {
            $now = Time::now()->i18nFormat('YYYY-MM-dd HH:mm:ss');
            $expression = new QueryExpression([
                'failed_login_count = failed_login_count + 1',
                'failed_login_timestamp = "' . $now . '"'
            ], [], ', ');

            $this->updateAll($expression, [
                'email' => $requestData['email']
            ]);

            return true;
        }

        return false;
    }

    /**
     * Finder used for authentications
     *
     * @param Query $query Query
     * @param array $options Options
     * @return Query
     */
    public function findAuth(\Cake\ORM\Query $query, array $options)
    {
        $query
            ->where([
                'Users.status' => Status::ACTIVE,
                'Users.failed_login_count <' => Configure::read('Authentication.max_login_retries')
            ]);

        return $query;
    }

    /**
     * Validates the new_password and password_confirm fields for a user and
     * saves them if valid.
     *
     * @param User $user User entity
     * @param array $postData Array containing new_password and password_confirm keys
     * @return User
     */
    public function resetPassword(User $user, array $postData)
    {
        $user->accessible('*', false);
        $user->accessible(['password'], true);
        $this->patchEntity($user, $postData, ['validate' => 'resetPassword']);
        if (empty($user->errors())) {
            $user->password = $postData['password'];

            return $this->save($user);
        }

        return $user;
    }

    /**
     * Validates the new_password and password_confirm fields for a user and
     * saves them if valid.
     *
     * @param User $user User entity
     * @param array $postData Array containing new_password and password_confirm keys
     * @return User
     */
    public function changePassword(User $user, array $postData)
    {
        $user->accessible('*', false);
        $user->accessible(['password'], true);
        $this->patchEntity($user, $postData, ['validate' => 'changePassword']);
        if (empty($user->errors())) {
            $user->password = $postData['password'];

            return $this->save($user);
        }

        return $user;
    }

    /**
     * creates a unique hash for User
     *
     * @param  User $user the user entity
     * @return string
     */
    public function getHash(User $user)
    {
        $vars = [
            $user->email,
            $user->id,
            $user->password,
            $user->modified,
            $user->status
        ];
        $secretStr = implode('', $vars);
        $hash = \Cake\Utility\Security::hash($secretStr, 'sha512', true);

        return $hash;
    }

    /**
     * Sends a forgot password email
     *
     * @param  User $user the user entity
     * @return void
     */
    public function sendForgotPasswordEmail(User $user)
    {
        $hash = $this->getHash($user);
        $token = ($hash . strtotime('now'));
        $restoreLink = Router::url([
            'plugin' => false,
            'controller' => 'Login',
            'action' => 'restorePassword',
            $user->id,
            $token
        ], true);

        $email = new EmailNotification();
        $email->template('forgot_password', 'default')
            ->emailFormat('html')
            ->to($user->email)
            ->subject(__('email.subject.forgot_password'))
            ->viewVars([
                'resetPasswordUrl' => $restoreLink,
                'fullName' => $user->full_name
            ])
            ->push();
    }

    /**
     * Softdeletes an user
     *
     * @param EntityInterface $user User Entity
     * @return mixed
     */
    public function softDelete(User $user)
    {
        $user = $this->patchEntity($user, ['status' => Status::DELETED]);

        return $this->save($user);
    }
}

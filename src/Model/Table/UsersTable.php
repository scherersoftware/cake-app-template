<?php
namespace App\Model\Table;

use App\Lib\Status;
use App\Model\Entity\User;
use Attachments\Model\Entity\Attachment;
use Cake\Auth\DefaultPasswordHasher;
use Cake\Core\Configure;
use Cake\Database\Expression\QueryExpression;
use Cake\Datasource\EntityInterface;
use Cake\Event\Event;
use Cake\I18n\Time;
use Cake\Network\Request;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Users Model
 *
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
        $this->displayField('email');
        $this->primaryKey('id');

        $this->addBehavior('Attachments.Attachments', [
            'downloadAuthorizeCallback' => function (Attachment $attachment, User $user, Request $request) {
                $loggedIn = $request->session()->check('Auth.User');
                if ($loggedIn) {
                    // Allowed for Admins
                    if ($request->session()->read('Auth.User.role') == User::ROLE_ADMIN) {
                        return true;
                    }
                    // Allowed for the posessing user himself
                    if ($request->session()->read('Auth.User.id') === $user->id) {
                        return true;
                    }
                }
                return false;
            }
        ]);

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
            ->add('id', 'valid', ['rule' => 'uuid'])
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
            ->add('email', 'valid', ['rule' => 'email'])
            ->requirePresence('email', 'create')
            ->notEmpty('email');

        $validator
            ->allowEmpty('password', 'update');

        $this->validationPassword($validator);

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
            ->notEmpty('password', 'Bitte geben Sie ein neues Passwort ein.', $shouldValidate)
            ->notEmpty('password_confirm', 'Bitte wiederholen Sie Ihr neues Passwort.', $shouldValidate)
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
     * Reset the login retries counter
     *
     * @param User $user User Entity
     * @return void
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
     * @param string $id id
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
}

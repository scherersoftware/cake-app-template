<?php
namespace App\Model\Table;

use App\Lib\Status;
use App\Model\Entity\User;
use Cake\Core\Configure;
use Cake\Database\Expression\QueryExpression;
use Cake\I18n\Time;
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
            ->allowEmpty('password');

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

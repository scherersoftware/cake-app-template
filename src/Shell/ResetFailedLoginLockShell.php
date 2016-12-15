<?php
namespace App\Shell;

use Cake\Console\Shell;
use Cake\Core\Configure;
use Cake\I18n\Time;

/**
 * ResetFailedLoginLock shell command.
 */
class ResetFailedLoginLockShell extends Shell
{

    /**
     * main() method.
     *
     * @return void
     */
    public function main()
    {
        $this->loadModel('Users');
        $timeAgo = '-' . Configure::read('Authentication.login_lock_duration');
        $timeLock = Time::parse($timeAgo);
        $lockedUsers = $this->Users->find()
            ->where([
                'Users.failed_login_count >=' => Configure::read('Authentication.max_login_retries'),
                'Users.failed_login_timestamp <' => $timeLock
            ])
            ->toArray();

        if (!empty($lockedUsers)) {
            $this->out('found ' . count($lockedUsers) . ' locked user to unlock');
            $i = 0;
            foreach ($lockedUsers as $user) {
                $user->login_retries = 0;
                $user->failed_login_timestamp = null;
                if ($this->Users->save($user)) {
                    $i++;
                }
            }
            $this->out('Unlocked ' . $i . ' user');
        } else {
            $this->out('found no locked user to unlock');
        }
    }
}
